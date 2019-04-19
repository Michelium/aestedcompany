<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller {

  /**
   * @Route("/home", name="home")
   */
  public function index() {
    $session = new Session();
    if (!$this->get('session')->get('mode') || !$this->get('session')->get('editMode')) {
      $session->set('mode', 'default');
      $session->set('editMode', 'off');
    }

    return $this->render("index.html.twig");
  }

  /**
   * @Route("/togglemode/{route}", name="togglemode")
   */
  public function toggleMode($route) {
    if ($this->get('session')->get('mode') == 'default') {
      $this->get('session')->set('mode', 'shisha');
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $this->get('session')->remove('mode');
      $this->get('session')->set('mode', 'default');
    }
    return $this->redirectToRoute($route);
  }

  /**
   * @Route("/toggleEditMode/{route}", name="toggleEditMode")
   */
  public function toggleEditMode($route) {
    if ($this->get('session')->get('editMode') == 'off') {
      $this->get('session')->set('editMode', 'on');
    } else if ($this->get('session')->get('editMode') == 'on') {
      $this->get('session')->remove('editMode');
      $this->get('session')->set('editMode', 'off');
    }
    return $this->redirectToRoute($route);
  }

}
