<?php

namespace App\Controller;

use App\Entity\Bestelling;
use App\Entity\Orders;
use App\Entity\Product;
use App\Form\BerekenVerkoopprijsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GeldController extends Controller {

  /**
   * @Route("/geldoverzicht", name="geldoverzicht")
   */
  public function showGeld() {
    $em = $this->getDoctrine()->getManager();

    //FINANCIËN AESTED COMPANY
    //Omzet en winst
    $omzetMaandJaarTotaal = $em->getRepository(Orders::class)->findOrdersTotalByMonthAndYear();

    $verzendKostenMaandJaarTotaal = $em->getRepository(Orders::class)->findVerzendkostenTotalByMonthAndYear();

    $bestellingMaandJaarTotaal = $em->getRepository(Bestelling::class)->findAllTotalBestellingenByMonth();

    //Bereken totale winst en per maand
    $winstMaandJaarTotaal = [];
    $winstTotaal = 0;
    for ($i = 0; $i < sizeof($omzetMaandJaarTotaal); $i++) {
      $tempIndex = $bestellingMaandJaarTotaal[$i]["Maand"] . $bestellingMaandJaarTotaal[$i]["Jaar"];
      $winstMaandJaarTotaal[$tempIndex] = [
          "Maand" => $bestellingMaandJaarTotaal[$i]["Maand"],
          "Jaar" => $bestellingMaandJaarTotaal[$i]["Jaar"],
          "Winst" => $omzetMaandJaarTotaal[$i]["Totaal"] - $bestellingMaandJaarTotaal[$i]["Totaal"] - $verzendKostenMaandJaarTotaal[$i]["Totaal"]];
      $winstTotaal += ($omzetMaandJaarTotaal[$i]["Totaal"] - $bestellingMaandJaarTotaal[$i]["Totaal"] - $verzendKostenMaandJaarTotaal[$i]["Totaal"]);
    }

    //Bereken totale omzet
    $omzetTotaal = 0;
    foreach ($omzetMaandJaarTotaal as $omjt) {
      $omzetTotaal += $omjt['Totaal'];
    }

    $bestellingTotaal = 0;
    foreach ($bestellingMaandJaarTotaal as $bmjt) {
      $bestellingTotaal += $bmjt['Totaal'];
    }
    #############

    //FINANCIËN PLUS SHISHA:
    //Omzet en winst
    $omzetMaandJaarTotaal2 = $em->getRepository(Orders::class)->findOrdersTotalByMonthAndYearEverything();

    $verzendKostenMaandJaarTotaal2 = $em->getRepository(Orders::class)->findVerzendkostenTotalByMonthAndYear();

    $bestellingMaandJaarTotaal2 = $em->getRepository(Bestelling::class)->findAllTotalBestellingenByMonthEverything();

    //Bereken totale winst en per maand
    $winstMaandJaarTotaal2 = [];
    $winstTotaal2 = 0;
    for ($i = 0; $i < sizeof($omzetMaandJaarTotaal2); $i++) {
      $tempIndex = $bestellingMaandJaarTotaal2[$i]["Maand"] . $bestellingMaandJaarTotaal2[$i]["Jaar"];
      $winstMaandJaarTotaal2[$tempIndex] = [
          "Maand" => $bestellingMaandJaarTotaal2[$i]["Maand"],
          "Jaar" => $bestellingMaandJaarTotaal2[$i]["Jaar"],
          "Winst" => $omzetMaandJaarTotaal2[$i]["Totaal"] - $bestellingMaandJaarTotaal2[$i]["Totaal"] - $verzendKostenMaandJaarTotaal2[$i]["Totaal"]];
      $winstTotaal2 += ($omzetMaandJaarTotaal2[$i]["Totaal"] - $bestellingMaandJaarTotaal2[$i]["Totaal"] - $verzendKostenMaandJaarTotaal2[$i]["Totaal"]);
    }

    //Bereken totale omzet
    $omzetTotaal2 = 0;
    foreach ($omzetMaandJaarTotaal2 as $omjt) {
      $omzetTotaal2 += $omjt['Totaal'];
    }

    $bestellingTotaal2 = 0;
    foreach ($bestellingMaandJaarTotaal2 as $bmjt) {
      $bestellingTotaal2 += $bmjt['Totaal'];
    }

    #########

    //Bereken maandrapport
    //get alle maanden+jaren met omzet
    $ordersMaandJaar = $em->getRepository(Orders::class)->findMonthAndYear();

    //Maakt nieuwe Array en gebruikt alle maand+jaar met Orders om alle Orders op te vragen per maand+jaar
    $allOrdersMaandJaar = [];
    foreach ($ordersMaandJaar as $key => $omj) {
      $allOrdersMaandJaar[$omj["Jaar"]][$omj["Maand"]] = $em->getRepository(Orders::class)->findByDate($omj["Jaar"], $omj["Maand"]);;

      $tempMonthNum = $omj["Maand"];
      $dateObj = \DateTime::createFromFormat('!m', $tempMonthNum);
      $monthName = $dateObj->format('F');

      $ordersMaandJaar[$key]["MaandNaam"] = $monthName;

      $dateObj = null;

    }

    return $this->render('mainpages/geld/geld.html.twig', [
        'omzetMaandJaarTotaal' => $omzetMaandJaarTotaal,
        'bestellingMaandJaarTotaal' => $bestellingMaandJaarTotaal,
        'winstMaandJaarTotaal' => $winstMaandJaarTotaal,
        'winstTotaal' => $winstTotaal,
        'omzetTotaal' => $omzetTotaal,
        'bestellingTotaal' => $bestellingTotaal,

        'omzetMaandJaarTotaal2' => $omzetMaandJaarTotaal2,
        'bestellingMaandJaarTotaal2' => $bestellingMaandJaarTotaal2,
        'winstMaandJaarTotaal2' => $winstMaandJaarTotaal2,
        'winstTotaal2' => $winstTotaal2,
        'omzetTotaal2' => $omzetTotaal2,
        'bestellingTotaal2' => $bestellingTotaal2,

        'allOrdersMaandJaar' => $allOrdersMaandJaar,
        'ordersMaandJaar' => $ordersMaandJaar,
    ]);
  }

  /**
   * @Route("/shisha/financien", name="shishaFinancien")
   */
  public function showShishaGeld() {
    $em = $this->getDoctrine()->getManager();

    //Omzet en winst
    $omzetMaandJaarTotaal = $em->getRepository(Orders::class)->findShishaOrdersTotalByMonthAndYear();

    $bestellingMaandJaarTotaal = $em->getRepository(Bestelling::class)->findAllTotalShishaBestellingenByMonth();

    //Bereken totale winst en per maand
    $winstMaandJaarTotaal = [];
    $winstTotaal = 0;
    for ($i = 0; $i < sizeof($omzetMaandJaarTotaal); $i++) {
      $tempIndex = $bestellingMaandJaarTotaal[$i]["Maand"] . $bestellingMaandJaarTotaal[$i]["Jaar"];
      $winstMaandJaarTotaal[$tempIndex] = [
          "Maand" => $bestellingMaandJaarTotaal[$i]["Maand"],
          "Jaar" => $bestellingMaandJaarTotaal[$i]["Jaar"],
          "Winst" => $omzetMaandJaarTotaal[$i]["Totaal"] - $bestellingMaandJaarTotaal[$i]["Totaal"]];
      $winstTotaal += ($omzetMaandJaarTotaal[$i]["Totaal"] - $bestellingMaandJaarTotaal[$i]["Totaal"]);
    }

    //Bereken totale omzet
    $omzetTotaal = 0;
    foreach ($omzetMaandJaarTotaal as $omjt) {
      $omzetTotaal += $omjt['Totaal'];
    }

    $bestellingTotaal = 0;
    foreach ($bestellingMaandJaarTotaal as $bmjt) {
      $bestellingTotaal += $bmjt['Totaal'];
    }

    //Bereken maandrapport
    //get alle maanden+jaren met omzet
    $ordersMaandJaar = $em->getRepository(Orders::class)->findMonthAndYear();

    //Maakt nieuwe Array en gebruikt alle maand+jaar met Orders om alle Orders op te vragen per maand+jaar
    $allOrdersMaandJaar = [];
    foreach ($ordersMaandJaar as $key => $omj) {
      $allOrdersMaandJaar[$omj["Jaar"]][$omj["Maand"]] = $em->getRepository(Orders::class)->findByDate($omj["Jaar"], $omj["Maand"]);;

      $tempMonthNum = $omj["Maand"];
      $dateObj = \DateTime::createFromFormat('!m', $tempMonthNum);
      $monthName = $dateObj->format('F');

      $ordersMaandJaar[$key]["MaandNaam"] = $monthName;

      $dateObj = null;

    }

    return $this->render('shisha/financien/shisha.financien.html.twig', [
        'omzetMaandJaarTotaal' => $omzetMaandJaarTotaal,
        'bestellingMaandJaarTotaal' => $bestellingMaandJaarTotaal,
        'winstMaandJaarTotaal' => $winstMaandJaarTotaal,
        'winstTotaal' => $winstTotaal,
        'omzetTotaal' => $omzetTotaal,
        'bestellingTotaal' => $bestellingTotaal,
        'allOrdersMaandJaar' => $allOrdersMaandJaar,
        'ordersMaandJaar' => $ordersMaandJaar,
    ]);
  }

  /**
   * @Route("/geldoverzicht/maandverslag/{jaar}/{maand}", name="geldoverzichtMaandverslag")
   */
  public function showMaandverslag($jaar, $maand) {
    $em = $this->getDoctrine()->getManager();

    $orders = $em->getRepository(Orders::class)->findByDate($jaar, $maand);

    if (!$orders) {
      return $this->redirectToRoute('geldoverzicht');
    }

    return $this->render('mainpages/geld/geld.maandverslag.html.twig', [

    ]);


  }

  /**
   * @Route("/geldoverzicht/berekenverkoopprijs/{shisha}", name="geldoverzichtBerekenVerkoopprijs", defaults={"shisha"=null})
   */
  public function berekenVerkoopprijs(Request $request, $shisha) {
    $em = $this->getDoctrine()->getManager();

    if ($shisha == "shisha") {
      $producten = $em->getRepository(Product::class)->findBy(array('shishapen' => true), array('categorie' => 'ASC'));
    } else {
      $producten = $em->getRepository(Product::class)->findBy(['shishapen' => false,], array('categorie' => 'ASC'));
    }

    $product1 =  $product1Aantal = $product1Gewicht = $product1Inkoop =
    $product2 = $product2Aantal = $product2Gewicht = $product2Inkoop =
    $product3 = $product3Aantal = $product3Gewicht = $product3Inkoop = null;

    if ($request->request->get('product1') != '0' && $request->request->get('product1') !== null) {
      $product1 = $em->getRepository(Product::class)->find($request->request->get('product1'));
      $product1Aantal = $request->request->get('product1aantal');
      $product1Gewicht = $product1->getGewicht() * $product1Aantal;
      $product1Inkoop = $product1->getInkoopprijs() * $product1Aantal;
    }

    if ($request->request->get('product2') != '0' && $request->request->get('product2') !== null) {
      $product2 = $em->getRepository(Product::class)->find($request->request->get('product2'));
      $product2Aantal = $request->request->get('product2aantal');
      $product2Gewicht = $product2->getGewicht() * $product2Aantal;
      $product2Inkoop = $product2->getInkoopprijs() * $product2Aantal;
    }

    if ($request->request->get('product3') != '0' && $request->request->get('product3') !== null) {
      $product3 = $em->getRepository(Product::class)->find($request->request->get('product3'));
      $product3Aantal = $request->request->get('product3aantal');
      $product3Gewicht = $product3->getGewicht() * $product3Aantal;
      $product3Inkoop = $product3->getInkoopprijs() * $product3Aantal;
    }

    $enveloppeGewicht = $request->request->get('typeEnv');

    $totaalInkoop = $product1Inkoop + $product2Inkoop + $product3Inkoop;
    $totaalGewicht = $product1Gewicht + $product2Gewicht + $product3Gewicht + $enveloppeGewicht;

    if ($totaalGewicht >= 0 && $totaalGewicht <= 15) {
      $verzendkosten = 0.87; # 1 postzegel
    } else if ($totaalGewicht >= 16 && $totaalGewicht <= 45) {
      $verzendkosten = 1.74; # 2 postzegel
    } else if ($totaalGewicht >= 46 && $totaalGewicht <= 95) {
      $verzendkosten = 2.61; # 3 postzegel
    } else if ($totaalGewicht >= 96) {
      $verzendkosten = 3.84; # 4 postzegel
    }

    $tempTotaal = $totaalInkoop + $verzendkosten;

    if ($tempTotaal > 20) {
      $winstmarge = 1.50;
    } else {
      $winstmarge = 1.70;
    }

    $totaal = ($totaalInkoop + $verzendkosten) * $winstmarge;

    return $this->render('mainpages/geld/geld.bv.html.twig', [
      'producten' => $producten,
      'product1' => $product1,
      'product1Aantal' => $product1Aantal,
      'product2' => $product2,
      'product2Aantal' => $product2Aantal,
      'product3' => $product3,
      'product3Aantal' => $product3Aantal,
      'verzendkosten' => $verzendkosten,
      'totaalGewicht' => $totaalGewicht,
      'totaal' => $totaal,
      'shisha' => $shisha,
    ]);
  }

}