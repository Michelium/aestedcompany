<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderProduct;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends Controller {

  /**
   * @Route("/shisha/orders", name="shishaOrders")
   */
  public function showOrders() {
    $em = $this->getDoctrine()->getManager();

    $orders = $em->getRepository('Klantenbestelling.php')->findBy(array('shishapen' => true), array('verkoopDatum' => 'DESC'));

    return $this->render("shisha/orders/shisha.orders.html.twig", [
        'user' => $this->getUser(),
        'orders' => $orders,
    ]);
  }


  /**
   * @Route("/shisha/detail/order/{id}", name="shishaOrderDetail")
   */
  public function showOrderDetail($id) {
    $em = $this->getDoctrine()->getManager();

    $order = $em->getRepository('Klantenbestelling.php')->find($id);

    $ordersProducts = $em->getRepository(OrderProduct::class)->findBy(array('order' => $order));
    return $this->render('shisha/orders/shisha.order.detail.html.twig', [
        'order' => $order,
        'ordersProducts' => $ordersProducts,
        'user' => $this->getUser(),
    ]);
  }

}