<?php

namespace App\Controller;

use App\Entity\Artikel;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AfzetController extends Controller {

  /**
   * @Route("/afzet", name="afzet_index")
   */
  public function index() {
    $em = $this->getDoctrine()->getManager();

    $artikelen = $artikelen0 = $artikelen1 = $artikelen2 = null;

    if ($this->get('session')->get('mode') == 'default') {
      $artikelen0 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 0, 'shishapen' => false]);
      $artikelen1 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 1, 'shishapen' => false]);
      $artikelen2 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 2, 'shishapen' => false]);
    } else {
      $artikelen = $em->getRepository(Artikel::class)->findBy(['shishapen' => true]);
    }

    return $this->render('afzet/afzet.html.twig', [
        'artikelen' => $artikelen,
        'artikelen0' => $artikelen0,
        'artikelen1' => $artikelen1,
        'artikelen2' => $artikelen2,
    ]);
  }

}