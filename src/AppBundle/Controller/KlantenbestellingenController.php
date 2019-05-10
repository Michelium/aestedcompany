<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Klantenbestelling;
use AppBundle\Entity\KlantenbestellingArtikel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class KlantenbestellingenController extends Controller {

  /**
   * @Route("/klantenbestellingen", name="klantenbestellingen_index")
   */
  public function klantenbestellingenIndex() {

    $em = $this->getDoctrine()->getManager();

    if ($this->get('session')->get('mode') == 'default') {
      $klantenbestellingen = $em->getRepository(Klantenbestelling::class)->findBy(['shishapen' => false], ['verkoopDatum' => 'DESC']);
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $klantenbestellingen = $em->getRepository(Klantenbestelling::class)->findBy(['shishapen' => true], ['verkoopDatum' => 'DESC']);
    }

    return $this->render('klantenbestellingen/klantenbestellingen.html.twig', [
      'klantenbestellingen' => $klantenbestellingen,
    ]);

  }

  /**
   * @Route("/klantenbestellingen/{id}", name="klantenbestellingen_show")
   */
  public function klantenbestellingenShow($id) {
    $em = $this->getDoctrine()->getManager();

    $klantenbestelling = $em->getRepository(Klantenbestelling::class)->find($id);

    if (!$klantenbestelling) {
      return $this->redirectToRoute('klantenbestellingen_index');
    }

    $klantenbestellingArtikelen = $em->getRepository(KlantenbestellingArtikel::class)->findBy(['klantenbestelling' => $klantenbestelling]);

    return $this->render('klantenbestellingen/show.html.twig', [
        'klantenbestelling' => $klantenbestelling,
        'klantenbestellingArtikelen' => $klantenbestellingArtikelen,
    ]);
  }

  /**
   * @Route("/klantenbestellingen/{id}/verzonden", name="klantenbestellingen_verzonden")
   */
  public function klantenbestellingSetVerzonden($id) {
    $em = $this->getDoctrine()->getManager();

    $klantenbestelling = $em->getRepository(Klantenbestelling::class)->find($id);

    if (!$klantenbestelling) {
      return $this->redirectToRoute('klantenbestellingen_index');
    }

    $klantenbestelling->setVerzonden(true);

    $em->persist($klantenbestelling);
    $em->flush();

    $this->addFlash('success', "Klantenbestelling 'verzonden' succesvol aangepast!");
    return $this->redirectToRoute('klantenbestellingen_show', ['id' => $id]);
  }

  /**
   * @Route("/klantenbestellingen/{id}/betaald", name="klantenbestellingen_betaald")
   */
  public function klantenbestellingSetBetaald($id) {
    $em = $this->getDoctrine()->getManager();

    $klantenbestelling = $em->getRepository(Klantenbestelling::class)->find($id);

    if (!$klantenbestelling) {
      return $this->redirectToRoute('klantenbestellingen_index');
    }

    $klantenbestelling->setBetaald(true);

    $em->persist($klantenbestelling);
    $em->flush();

    $this->addFlash('success', "Klantenbestelling 'betaald' succesvol aangepast!");
    return $this->redirectToRoute('klantenbestellingen_show', ['id' => $id]);
  }

}