<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bestelling;
use AppBundle\Form\BestellingBezorgType;
use AppBundle\Form\BestellingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BestellingenController extends Controller {

  /**
   * @Route("/bestellingen/openstaand", name="bestellingen_openstaandIndex")
   */
  public function openstaandIndex() {
    $em = $this->getDoctrine()->getManager();

    if ($this->get('session')->get('mode') == 'default') {
      $bestellingen = $em->getRepository(Bestelling::class)->findBy(['ontvangen' => false, 'shishapen' => false], array('ontvangstdatum' => 'DESC'));
    } else {
      $bestellingen = $em->getRepository(Bestelling::class)->findBy(['ontvangen' => false, 'shishapen' => true], array('ontvangstdatum' => 'DESC'));
    }


    return $this->render("bestellingen/openstaand.html.twig", [
        'bestellingen' => $bestellingen,
    ]);
  }

  /**
   * @Route("/bestellingen/bezorgd", name="bestellingen_bezorgdIndex")
   */
  public function bezorgdIndex() {
    $em = $this->getDoctrine()->getManager();

    if ($this->get('session')->get('mode') == 'default') {
      $bestellingen = $em->getRepository(Bestelling::class)->findBy(['ontvangen' => true, 'shishapen' => false], array('ontvangstdatum' => 'DESC'));
    } else {
      $bestellingen = $em->getRepository(Bestelling::class)->findBy(['ontvangen' => true, 'shishapen' => true], array('ontvangstdatum' => 'DESC'));
    }

    return $this->render('bestellingen/bezorgd.html.twig', [
        'bestellingen' => $bestellingen,
    ]);
  }

  /**
   * @Route("/bestellingen/invoeren", name="bestellingen_invoerenIndex")
   */
  public function invoerenIndex(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $bestelling = new Bestelling();

    if ($this->get('session')->get('mode') == 'default') {
      $shishaOption = false;
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $shishaOption = true;
      $bestelling->setShishapen(true);
    }

    $form = $this->createForm(BestellingType::class, $bestelling, ['shishaOption' => $shishaOption]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      if ($form->get('productextra')->getData() != null) {
        $bestelling->setCustomName(true);
        $bestelling->setNaam($form->get('productextra')->getData());
      } else {
        $bestelling->setArtikel($form->get('artikel')->getData());
      }

      $em->persist($bestelling);
      $em->flush();

      $this->addFlash('success', 'Bestelling succesvol aangemaakt!');
      $bestellingID = $bestelling->getId();
      return $this->redirectToRoute('bestellingen_openstaandIndex', ['id' => $bestellingID]);
    }

    return $this->render('bestellingen/invoeren.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/bestellingen/{id}/bezorgen", name="bestellingen_bezorgen")
   */
  public function bestellingBezorgen($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    $bestelling = $em->getRepository(Bestelling::class)->find($id);

    if (!$bestelling) {
      throw $this->createNotFoundException('Bestelling niet gevonden');
    } else {
      if ($bestelling->getOntvangen() === true) {
        throw new \Exception('Bestelling is al bezorgd');
      }
    }

    if ($bestelling->getCustomName() === false) {
      $artikel = $bestelling->getArtikel();
      $bestellingAantal = $bestelling->getAantal();
      $artikel->setVoorraad($artikel->getVoorraad() + $bestellingAantal);
    }

    $form = $this->createForm(BestellingBezorgType::class, $bestelling);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $bestelling->setOntvangstdatum(new \DateTime());
      $bestelling->setOntvangen(true);

      $em->persist($bestelling);
      $em->flush();

      $this->addFlash('success', 'Bestelling succesvol bezorgd!');

      return $this->redirectToRoute('bestellingen_bezorgdIndex');
    }

    return $this->render('bestellingen/bezorgen.html.twig', [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/bestellingen/{id}/update", name="bestellingen_update")
   */
  public function bestellingUpdate($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    $bestelling = $em->getRepository(Bestelling::class)->find($id);

    if ($this->get('session')->get('mode') == 'default') {
      $shishaOption = false;
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $shishaOption = true;
    }

    if (!$bestelling) {
      throw $this->createNotFoundException('Bestelling niet gevonden');
    } else {
      if ($bestelling->getOntvangen() === true) {
        throw new \Exception('Bezorgde bestellingen kunnen niet meer worden bewerkt');
      }
    }

    $form = $this->createForm(BestellingType::class, $bestelling, ['shishaOption' => $shishaOption]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em->persist($bestelling);
      $em->flush();

      $this->addFlash('success', 'Bestelling succesvol geüpdatet!');
      $bestellingID = $bestelling->getId();
      return $this->redirectToRoute('bestellingen_openstaandIndex', ['id' => $bestellingID]);
    }

    return $this->render('bestellingen/update.html.twig', [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/bestellingen/{id}", name="bestellingen_show")
   */
  public function bestellingShow($id) {
    $em = $this->getDoctrine()->getManager();

    $bestelling = $em->getRepository(Bestelling::class)->find($id);

    if (!$bestelling) {
      throw $this->createNotFoundException('Bestelling niet gevonden');
    }

    return $this->render('bestellingen/show.html.twig', [
        'bestelling' => $bestelling,
    ]);
  }

  /**
   * @Route("/bestellingen/{id}/delete", name="bestellingen_delete")
   */
  public function bestellingDelete($id) {
    $em = $this->getDoctrine()->getManager();

    $bestelling = $em->getRepository(Bestelling::class)->find($id);

    if (!$bestelling) {
      throw $this->createNotFoundException('Bestelling niet gevonden');
    } else {
      if ($bestelling->getOntvangen() === true) {
        throw new \Exception('Bezorgde bestellingen kunnen niet meer worden verwijderd');
      }
    }

    $em->remove($bestelling);
    $em->flush();

    $this->addFlash('danger', 'Bestelling succesvol verwijderd!');

    return $this->redirectToRoute('bestellingen_openstaandIndex');

  }



}