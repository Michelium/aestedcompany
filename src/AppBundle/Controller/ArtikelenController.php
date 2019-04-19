<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artikel;
use AppBundle\Entity\Categorie;
use AppBundle\Form\ArtikelType;
use AppBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArtikelenController extends Controller {

  /**
   * @Route("/artikelen/artikelen", name="artikelen_artikelenIndex")
   */
  public function artikelenIndex() {
    $em = $this->getDoctrine()->getManager();

    $artikelen = $artikelen0 = $artikelen1 = $artikelen2 = null;

    if ($this->get('session')->get('mode') == 'default') {
      $artikelen0 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 0, 'shishapen' => false]);
      $artikelen1 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 1, 'shishapen' => false]);
      $artikelen2 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 2, 'shishapen' => false]);
    } else {
      $artikelen = $em->getRepository(Artikel::class)->findBy(['shishapen' => true]);
    }

    return $this->render('artikelen/artikelen.html.twig', [
      'artikelen' => $artikelen,
      'artikelen0' => $artikelen0,
      'artikelen1' => $artikelen1,
      'artikelen2' => $artikelen2,
    ]);
  }

  /**
   * @Route("/artikelen/artikelen/create", name="artikelen_artikelenCreate")
   */
  public function artikelenCreate(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $artikel = new Artikel();

    $form = $this->createForm(ArtikelType::class, $artikel);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      if ($this->get('session')->get('mode') == 'shisha') {
        $artikel->setShishapen(true);
      }

      $em->persist($artikel);
      $em->flush();

      $this->addFlash('success', 'Artikel succesvol toegevoegd!');

      return $this->redirectToRoute('artikelen_artikelenIndex');
    }

    return $this->render('artikelen/artikelencreate.html.twig', [
      'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/artikelen/artikelen/{id}/update", name="artikelen_artikelenUpdate")
   */
  public function artikelenUpdate(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $artikel = $em->getRepository(Artikel::class)->find($id);
    if (!$artikel) {
      throw $this->createNotFoundException('Artikel niet gevonden');
    }
    $artikelCategorie = $artikel->getCategorie();

    $form = $this->createForm(ArtikelType::class, $artikel);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $artikel->setCategorie($artikelCategorie);
      $em->persist($artikel);
      $em->flush();

      $this->addFlash('success', 'Artikel succesvol geüpdatet!');

      return $this->redirectToRoute('artikelen_artikelenIndex');
    }

    return $this->render('artikelen/artikelenupdate.html.twig', [
        'form' => $form->createView(),
    ]);

  }

  /**
   * @Route("/artikelen/artikelen/{id}", name="artikelen_artikelenShow")
   */
  public function artikelenShow($id) {
    $em = $this->getDoctrine()->getManager();

    $artikel = $em->getRepository(Artikel::class)->find($id);
    if (!$artikel) {
      throw $this->createNotFoundException('Artikel niet gevonden');
    }

    return $this->render('artikelen/artikeleninfo.html.twig', [
       'artikel' => $artikel,
    ]);
  }

  /**
   * @Route("/artikelen/categorien", name="artikelen_categorienIndex")
   */
  public function categorienIndex() {
    $em = $this->getDoctrine()->getManager();

    $categorien = $em->getRepository(Categorie::class)->findAll();

    return $this->render('artikelen/categorien.html.twig', [
      'categorien' => $categorien,
    ]);
  }

  /**
   * @Route("/artikelen/categoriencreate", name="artikelen_categorienCreate")
   */
  public function categorienCreate(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $categorie = new Categorie();

    $form = $this->createForm(CategorieType::class, $categorie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $errorMessage = null;

      $checkCategorie = $em->getRepository(Categorie::class)->findBy(['naam' => $categorie->getNaam()]);

      if ($checkCategorie) {
        $errorMessage = 'Er bestaat al een categorie met deze naam';
      }

      if (!$errorMessage) {
        $em->persist($categorie);
        $em->flush();
        $this->addFlash('success', 'Categorie succesvol toegevoegd!');
        return $this->redirectToRoute('artikelen_categorienIndex');
      } else {
        $this->addFlash('danger', $errorMessage);
      }

    }

    return $this->render('artikelen/categoriencreate.html.twig', [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/artikelen/categorie/{id}/update", name="artikelen_categorienUpdate")
   */
  public function categorienUpdate(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $categorie = $em->getRepository(Categorie::class)->find($id);
    if (!$categorie) {
      throw $this->createNotFoundException('Categorie niet gevonden');
    }

    $form = $this->createForm(CategorieType::class, $categorie);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $errorMessage = null;

      $checkCategorie = $em->getRepository(Categorie::class)->findBy(['naam' => $categorie->getNaam()]);

      if ($checkCategorie) {
        $errorMessage = 'Er bestaat al een categorie met deze naam';
      }

      if (!$errorMessage) {
        $em->persist($categorie);
        $em->flush();
        $this->addFlash('success', 'Categorie succesvol geüpdatet!');
        return $this->redirectToRoute('artikelen_categorienIndex');
      } else {
        $this->addFlash('danger', $errorMessage);
      }

    }

    return $this->render('artikelen/categorienupdate.html.twig', [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/artikelen/categorie/{id}/delete", name="artikelen_categorienDelete")
   */
  public function categorienDelete($id) {
    $em = $this->getDoctrine()->getManager();

    $categorie = $em->getRepository(Categorie::class)->find($id);
    if (!$categorie) {
      throw $this->createNotFoundException('Categorie niet gevonden');
    }

    $em->remove($categorie);
    $em->flush();
    $this->addFlash('danger', "Categorie succesvol verwijderd!");

    return $this->redirectToRoute('artikelen_categorienIndex');

  }

}