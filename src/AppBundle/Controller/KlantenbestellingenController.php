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
   * @Route("/klantenbestellingen/{id}", name="klantenbestellingen_info")
   */
  public function showOrderDetail($id) {
    $em = $this->getDoctrine()->getManager();

    $klantenbestelling = $em->getRepository(Klantenbestelling::class)->find($id);

    if (!$klantenbestelling) {
      return $this->redirectToRoute('klantenbestellingen_index');
    }

    $klantenbestellingArtikelen = $em->getRepository(KlantenbestellingArtikel::class)->findBy(['klantenbestelling' => $klantenbestelling]);

    return $this->render('klantenbestellingen/info.html.twig', [
        'klantenbestelling' => $klantenbestelling,
        'klantenbestellingArtikelen' => $klantenbestellingArtikelen,
    ]);
  }

}