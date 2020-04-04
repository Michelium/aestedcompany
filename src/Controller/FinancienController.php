<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class FinancienController extends Controller {

  /**
   * @Route("/financien", name="financien_index")
   */
  public function index() {
    $em = $this->getDoctrine()->getManager();

    // TODO : Financien bundle

    return $this->render('financien/financien.html.twig', [

    ]);
  }

}