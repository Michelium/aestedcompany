<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bestelling;
use AppBundle\Entity\Orders;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AfzetOmzetController extends Controller {

  /**
   * @Route("/afzetomzet", name="afzetomzet")
   */
  public function showAfzetOmzet() {
    $em = $this->getDoctrine()->getManager();

    $producten0 = $em->getRepository('AppBundle\Entity\Product')->findBy(array('populariteit' => 0)); //specials
    $producten1 = $em->getRepository('AppBundle\Entity\Product')->findBy(array('populariteit' => 1)); //actieve verkoop
    $producten2 = $em->getRepository('AppBundle\Entity\Product')->findBy(array('populariteit' => 2)); //shisha pennen
    $producten3 = $em->getRepository('AppBundle\Entity\Product')->findBy(array('populariteit' => 3)); //blacklist

    return $this->render('mainpages/afzetomzet/afzetomzet.html.twig', [
        'producten0' => $producten0,
        'producten1' => $producten1,
        'producten2' => $producten2,
        'producten3' => $producten3,
    ]);
  }

  /**
   * @Route("/shisha/afzetomzet", name="shishaAfzetomzet")
   */
  public function showShishaAfzetOmzet() {
    $em = $this->getDoctrine()->getManager();

    $producten = $em->getRepository(Product::class)->findBy(array('shishapen' => true));

    return $this->render('shisha/afzetomzet/shisha.afzetomzet.html.twig', [
        'producten' => $producten
    ]);
  }

}