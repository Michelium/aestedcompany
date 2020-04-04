<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\CategorieType;
use App\Form\ProductType;
use App\Form\ShishaArtikelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends Controller {

  /**
   * @Route("/producten", name="producten")
   */
  public function showProducten() {

    $em = $this->getDoctrine()->getManager();

    $producten0 = $em->getRepository('App\Entity\Product')->findBy(array('populariteit' => 0, 'shishapen' => false)); //specials
    $producten1 = $em->getRepository('App\Entity\Product')->findBy(array('populariteit' => 1, 'shishapen' => false)); //actieve verkoop
    $producten2 = $em->getRepository('App\Entity\Product')->findBy(array('populariteit' => 2, 'shishapen' => false)); //shisha pennen

    return $this->render("mainpages/producten/producten.html.twig", [
        'user' => $this->getUser(),
        'producten0' => $producten0,
        'producten1' => $producten1,
        'producten2' => $producten2,
    ]);
  }

  /**
   * @Route("/shisha/artikelen", name="shishaArtikelen")
   */
  public function showShishaArtikelen() {
    $em = $this->getDoctrine()->getManager();

    $producten = $em->getRepository('App\Entity\Product')->findBy(array('shishapen' => true));

    return $this->render("shisha/shishapennenlijst/shisha.artikelen.html.twig", [
        'producten' => $producten,
    ]);
  }

  /**
   * @Route("/producten/{dir}/{id}", name="productenMovePop")
   */
  public function updatePopulariteit($dir, $id) {
    $em = $this->getDoctrine()->getManager();

    $product = $em->getRepository(Product::class)->find($id);

    if (!$product || $product->getId() === 78) {
      return $this->redirectToRoute('producten');
    }

    if ($dir === "up") {
      if ($product->getPopulariteit() == 1) {
        $product->setPopulariteit(0);
      } else if ($product->getPopulariteit() == 2) {
        $product->setPopulariteit(1);
      } else if ($product->getPopulariteit() == 3) {
        $product->setPopulariteit(2);
      }
    } else if ($dir === "down") {
      if ($product->getPopulariteit() == 0) {
        $product->setPopulariteit(1);
      } else if ($product->getPopulariteit() == 1) {
        $product->setPopulariteit(2);
      } else if ($product->getPopulariteit() == 2) {
        $product->setPopulariteit(3);
      }
    }

    $em->persist($product);
    $em->flush();

    return $this->redirectToRoute('producten');
  }


  /**
   * @Route("/producten/{id}", name="productInfo")
   */
  public function showProductInfo($id) {
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository(Product::class)->find($id);
    if (!$product || $product->getId() === 78) {
      return $this->redirectToRoute('producten');
    }

    //bereken minimale verkoopprijs
    $gewicht = $product->getGewicht();
    $inkoopprijs = $product->getInkoopprijs();
    if ($gewicht >= 0 && $gewicht <= 15) {
      $verzendkosten = 0.87; # 1 postzegel
    } else if ($gewicht >= 16 && $gewicht <= 45) {
      $verzendkosten = 1.74; # 2 postzegel
    } else if ($gewicht >= 46 && $gewicht <= 95) {
      $verzendkosten = 2.61; # 3 postzegel
    } else if ($gewicht >= 96) {
      $verzendkosten = 3.84; # 4 postzegel
    }
    $minimaleVerkoopprijs = ($inkoopprijs + $verzendkosten) * 1.30;
    $product->setMinimaleVerkoopprijs($minimaleVerkoopprijs);

    $em->persist($product);
    $em->flush();



    return $this->render(':mainpages/producten:producten.info.html.twig', [
        'product' => $product,
    ]);

  }

  /**
   * @Route("/productenadd/product", name="addProduct")
   */
  public function addProduct(Request $request) {

    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(ProductType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $product = $form->getData();
      $categorieNaam = $form->get('categorie')->getData();

      $product->setCategorie($categorieNaam);
      $em->persist($product);
      $em->flush();

      return $this->redirectToRoute('producten');
    }

    return $this->render("mainpages/producten/producten.product.add.html.twig", [
        'addProductForm' => $form->createView(),
    ]);
  }

  /**
   * @Route("/shisha/artikelen/add", name="shishaArtikelenAdd")
   */
  public function addShishaArtikel(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(ShishaArtikelType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $product = $form->getData();

      $product->setShishapen(true);
      $product->setPopulariteit(null);

      $em->persist($product);
      $em->flush();

      return $this->redirectToRoute('shishaArtikelen');
    }

    return $this->render("shisha/shishapennenlijst/shisha.artikelen.add.html.twig", [
        'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/shisha/artikelen/update/{id}", name="shishaArtikelenUpdate")
   */
  public function updateShishaProduct(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $product = $em->getRepository(Product::class)->find($id);
    $smaak = $product->getSmaak();

    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);

    if ($form->isSubmitted()) {
      $product->setGewicht($form->get('gewicht')->getData());
      $product->setInkoopprijs($form->get('inkoopprijs')->getData());
      $product->setAdviesprijs($form->get('adviesprijs')->getData());
      $product->setMinimaleVoorraad($form->get('minimaleVoorraad')->getData());
      $product->setSmaak($smaak);
      $em->persist($product);
      $em->flush();

      return $this->redirectToRoute('shishaArtikelen');
    }

    return $this->render("shisha/shishapennenlijst/shisha.artikelen.update.html.twig", [
        'user' => $this->getUser(),
        'updateProductForm' => $form->createView(),
    ]);
  }

  /**
   * @Route("/productenadd/categorie", name="addCategorie")
   */
  public function addCategorie(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(CategorieType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $categorie = $form->getData();

      $em->persist($categorie);
      $em->flush();

      return $this->redirectToRoute('producten');
    }

    return $this->render("mainpages/producten/producten.categorie.add.html.twig", [
        'addCategorieForm' => $form->createView(),
    ]);
  }

  /**
   * @Route("/productenupdate/{id}", name="updateProduct")
   */
  public function updateProduct(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $product = $em->getRepository(Product::class)->find($id);
    $productnaam = $product->getProductnaam();
    $productcat = $product->getCategorie();

    $form = $this->createForm(ProductType::class, $product);

    $form->handleRequest($request);

    if ($form->isSubmitted()) {
      $product->setGewicht($form->get('gewicht')->getData());
      $product->setInkoopprijs($form->get('inkoopprijs')->getData());
      $product->setAdviesprijs($form->get('adviesprijs')->getData());
      $product->setMinimaleVoorraad($form->get('minimaleVoorraad')->getData());
      $product->setProductnaam($productnaam);
      $product->setCategorie($productcat);
      $em->persist($product);
      $em->flush();

      return $this->redirectToRoute('producten');
    }

    return $this->render("mainpages/producten/producten.update.html.twig", [
        'user' => $this->getUser(),
        'updateProductForm' => $form->createView(),
    ]);
  }

  /**
   * @Route("/producten/delete/{id}", name="deleteProduct")
   */
  public function deleteProduct(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $product = $em->getRepository(Product::class)->find($id);

    $em->remove($product);
    $em->flush();
    return $this->redirectToRoute('producten');
  }

}