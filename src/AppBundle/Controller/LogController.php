<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderProduct;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends Controller {

  /**
   * @Route("/log", name="log")
   */
  public function showLog() {
    $em = $this->getDoctrine()->getManager();

    $orders = $em->getRepository('Klantenbestelling.php')->findBy(array('shishapen' => false), array('verkoopDatum' => 'DESC'));

    return $this->render("mainpages/log/log.html.twig", [
        'user' => $this->getUser(),
        'orders' => $orders,
    ]);
  }

  /**
   * @Route("/log/verzenden/{id}", name="logVerzenden")
   */
  public function verzendOrder($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    $order = $em->getRepository(Orders::class)->find($id);

    if (!$order || $order->getVerzonden() == true) {
      return $this->redirectToRoute('log');
    }

    $form = $this->createFormBuilder()
        ->add('verwachteleverdatum', DateType::class, array(
            'data' => new \DateTime('+1 day'),
            'format' => 'dd-MM-yyyy',
        ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $verwachteleverdatum = $form->get('verwachteleverdatum')->getData();

      $order->setVerwachteLeverdatum($verwachteleverdatum);
      $order->setVerzonden(true);
      $em->persist($order);
      $em->flush();

      return $this->redirectToRoute('log');
    }

    return $this->render(':mainpages/log:log.verzenden.html.twig', [
        'form' => $form->createView(),
    ]);

  }

  /**
   * @Route("/log/detail/{id}", name="logdetail")
   */
  public function showLogDetail($id) {
    $em = $this->getDoctrine()->getManager();

    $order = $em->getRepository('Klantenbestelling.php')->find($id);

    $ordersProducts = $em->getRepository(OrderProduct::class)->findBy(array('order' => $order));
    return $this->render('mainpages/log/log.detail.html.twig', [
        'order' => $order,
        'ordersProducts' => $ordersProducts,
        'user' => $this->getUser(),
    ]);
  }

  /**
   * @Route("/log/betalingontvangen/{id}", name="logontvangen")
   */
  public function setBetalingOntvangen($id) {
    $em = $this->getDoctrine()->getManager();
    $order = $em->getRepository(Orders::class)->find($id);

    if (!$order || $order->getBetaald() === true) {
      return $this->redirectToRoute('log');
    }

    $order->setBetaald(true);
    $em->persist($order);
    $em->flush();
    return $this->redirectToRoute('log');
  }
}