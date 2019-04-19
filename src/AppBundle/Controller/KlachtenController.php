<?php


namespace AppBundle\Controller;


use AppBundle\Entity\Klacht;
use AppBundle\Form\KlachtType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class KlachtenController extends Controller {

  /**
   * @Route("/klachten", name="klachten")
   */
  public function showKlachten(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $klachten = $em->getRepository(Klacht::class)->findBy(['voltooid' => false]);
    $klachtenVoltooid = $em->getRepository(Klacht::class)->findBy(['voltooid' => true]);

    $klacht = new Klacht();

    $form = $this->createForm(KlachtType::class, $klacht);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {

      $em->persist($klacht);
      $em->flush();

      $message = (new \Swift_Message('Aested Company | Nieuwe klacht'))
          ->setFrom('support@aested.nl')
          ->setTo('michelhamelink@gmail.com')
          ->setBody(
              $this->renderView(
                  'emails/emails.klacht.html.twig',
                  ['klacht' => $klacht]
              ),
              'text/html'
          )
      ;

      $this->get('mailer')->send($message);

      return $this->redirectToRoute('klachten');
    }

    return $this->render(':mainpages/klachten:klachten.html.twig', [
        'form' => $form->createView(),
        'klachten' => $klachten,
        'klachtenVoltooid' => $klachtenVoltooid,
    ]);
  }

  /**
   * @Route("/klachten/voltooien/{id}", name="klachtenVoltooien")
   */
  public function voltooiKlacht($id) {
    $em = $this->getDoctrine()->getManager();

    $klacht = $em->getRepository(Klacht::class)->find($id);

    $klacht->setVoltooid(true);
    $klacht->setDatumvoltooid(new \DateTime());

    $em->persist($klacht);
    $em->flush();

    return $this->redirectToRoute('klachten');
  }

}