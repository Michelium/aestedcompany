<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Opmerking;
use AppBundle\Form\OpmerkingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OpmerkingenController extends Controller {

  /**
   * @Route("/opmerkingen", name="opmerkingen_index")
   */
  public function opmerkingenIndex(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $opmerkingen = $em->getRepository(Opmerking::class)->findBy(['voltooid' => false]);
    $opmerkingenVoltooid = $em->getRepository(Opmerking::class)->findBy(['voltooid' => true]);

    $opmerking = new Opmerking();

    $form = $this->createForm(OpmerkingType::class, $opmerking);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()) {

      $em->persist($opmerking);
      $em->flush();

      $this->addFlash('success', 'Opmerking succesvol verzonden!');

//      $message = (new \Swift_Message('Aested Company | Nieuwe klacht'))
//          ->setFrom('support@aested.nl')
//          ->setTo('michelhamelink@gmail.com')
//          ->setBody(
//              $this->renderView(
//                  'emails/opmerking.html.twig',
//                  ['opmerking' => $opmerking]
//              ),
//              'text/html'
//          )
//      ;
//
//      $mailer->send($message);

      return $this->redirectToRoute('opmerkingen_index');
    }

    return $this->render('opmerkingen/opmerkingen.html.twig', [
        'form' => $form->createView(),
        'opmerkingen' => $opmerkingen,
        'opmerkingenVoltooid' => $opmerkingenVoltooid,
    ]);
  }

  /**
   * @Route("/opmerking/{id}/voltooien", name="opmerkingen_voltooien")
   */
  public function opmerkingVoltooi($id) {
    $em = $this->getDoctrine()->getManager();

    $opmerking = $em->getRepository(Opmerking::class)->find($id);

    if (!$opmerking) {
      throw $this->createNotFoundException('Opmerking niet gevonden');
    }

    $opmerking->setVoltooid(true);
    $opmerking->setDatumvoltooid(new \DateTime());

    $em->persist($opmerking);
    $em->flush();

    $this->addFlash('success', 'Opmerking succesvol afgerond!');

    return $this->redirectToRoute('opmerkingen_index');
  }

}