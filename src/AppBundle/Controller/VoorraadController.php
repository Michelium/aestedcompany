<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Afschrijving;
use AppBundle\Entity\Artikel;
use AppBundle\Entity\Klantenbestelling;
use AppBundle\Entity\KlantenbestellingArtikel;
use AppBundle\Form\AfschrijfType;
use AppBundle\Form\ArtikelenVerkopenType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VoorraadController extends Controller {

  public function __construct() {
    $this->array = null;
  }

  /**
   * @Route("/voorraad/voorraadartikel", name="voorraad_voorraadArtikelIndex")
   */
  public function voorraadArtikelIndex() {
    $em = $this->getDoctrine()->getManager();

    $artikelen = $artikelen0 = $artikelen1 = $artikelen2 = null;

    if ($this->get('session')->get('mode') == 'default') {
      $artikelen0 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 0, 'shishapen' => false]);
      $artikelen1 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 1, 'shishapen' => false]);
      $artikelen2 = $em->getRepository(Artikel::class)->findBy(['populariteit' => 2, 'shishapen' => false]);
    } else {
      $artikelen = $em->getRepository(Artikel::class)->findBy(['shishapen' => true]);
    }

    return $this->render('voorraad/voorraad_artikel.html.twig', [
        'artikelen' => $artikelen,
        'artikelen0' => $artikelen0,
        'artikelen1' => $artikelen1,
        'artikelen2' => $artikelen2,
    ]);
  }

  /**
   * @Route("/voorraad/artikelenverkopen", name="voorraad_artikelenVerkopenIndex")
   */
  public function artikelenVerkopenIndex(Request $request) {
    $em = $this->getDoctrine()->getManager();

    if ($this->get('session')->get('mode') == 'default') {
      $shishaOption = false;
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $shishaOption = true;
    }

    //Klantenbestelling wordt aangemaakt
    $klantenbestelling = new Klantenbestelling();
    $form = $this->createForm(ArtikelenVerkopenType::class, $klantenbestelling, ['shishaOption' => $shishaOption]);

    $form->handleRequest($request);

    //Wanneer gebruiker het form opstuurt.
    if ($form->isSubmitted() && $form->isValid()) {

      $errorMessage = null;

      # Totalen variabelen
      $totaalGewicht = 0;
      $totaalPrijs = $form->get('verkoopprijs')->getData();


      for ($i = 1; $i <= 6; $i++) {
        $artikel = $form->get('artikel' . $i . '')->getData();

        if ($artikel) {
          if ($form->get('artikel' . $i . 'Aantal')->getData() !== null) {
            if ($artikel->canBeSold($form->get('artikel' . $i . 'Aantal')->getData())) {
              # Product van voorraad afhalen
              $artikel->setVoorraad($artikel->getVoorraad() - $form->get('artikel' . $i . 'Aantal')->getData());
              if ($form->get('verkocht')->getData() === true) {
                $artikel->setAfzet($artikel->getAfzet() + $form->get('artikel' . $i . 'Aantal')->getData());
              }
              $em->persist($artikel);

              # Product gewicht optellen bij totaalgewicht
              $totaalGewicht += ($artikel->getGewicht() * $form->get('artikel' . $i . 'Aantal')->getData());

              $klantenbestellingArtikel = new KlantenbestellingArtikel();
              $klantenbestellingArtikel->setKlantenbestelling($klantenbestelling);
              $klantenbestellingArtikel->setArtikel($artikel);
              $klantenbestellingArtikel->setAantal($form->get('artikel' . $i . 'Aantal')->getData());
              $em->persist($klantenbestellingArtikel);

            } else {
              $errorMessage = "Het artikel: " . $artikel->getNaam() . " heeft niet genoeg voorraad. (Huidige vooraad: " . $artikel->getVoorraad() . ")";
              break;
            }
          } else {
            $errorMessage = "Het aantal van artikel " . $i . " is niet ingevuld.";
            break;
          }
        }
      }

      # Enveloppegewicht ophalen
      $enveloppeGewicht = $form->get('typeEnv')->getData();

      if ($enveloppeGewicht !== 0) {
        #Enveloppegewicht bij totaalgewicht optellen
        $totaalGewicht += $form->get('typeEnv')->getData();

        # Postzegels berekenen
        if ($totaalGewicht >= 0 && $totaalGewicht <= 15) {
          $postzegelAantal = 1;
        } else if ($totaalGewicht >= 16 && $totaalGewicht <= 45) {
          $postzegelAantal = 2;
        } else if ($totaalGewicht >= 46 && $totaalGewicht <= 95) {
          $postzegelAantal = 3;
        } else if ($totaalGewicht >= 96) {
          $postzegelAantal = 4;
        }
        # Postzegels ophalen uit database en van voorraad afschrijven
        $postzegels = $em->getRepository(Artikel::class)->find(1);
        if ($postzegelAantal <= $postzegels->getVoorraad()) {
          $postzegels->setVoorraad($postzegels->getVoorraad() - $postzegelAantal);
          $em->persist($postzegels);
        } else {
          $errorMessage = "Je hebt niet genoeg postzegels op voorraad. (Huidige voorraad: " . $postzegels->getVoorraad() . ")";
        }
      } else {
        $postzegelAantal = 0;
      }
      $klantenbestelling->setPostzegels($postzegelAantal);

      # Berekenen van adres
      if ($form->get('postcode')->getData() != null) {
        $this->berekenAdres($form->get('postcode')->getData(), $form->get('huisnummer')->getData(), $form->get('toevoegsel')->getData());
        $klantenbestelling->setAdres($this->getStraat() . " " . $form->get('huisnummer')->getData() . $form->get('toevoegsel')->getData());
        $klantenbestelling->setStad($this->getStad());
      } else {
        $klantenbestelling->setPostcode("Niet ingevuld");
        $klantenbestelling->setAdres("Niet ingevuld");
        $klantenbestelling->setStad("Niet ingevuld");
      }

      # Zet totaalgewicht in klantenbestelling
      $klantenbestelling->setTotaalgewicht($totaalGewicht);

      # Maak van de klantenbestelling een shishapen klantenbestelling
      if ($this->get('session')->get('mode') == 'default') {
        $klantenbestelling->setShishapen(false);
      } else if ($this->get('session')->get('mode') == 'shisha') {
        $klantenbestelling->setShishapen(true);
      }

      # Zet totaalprijs in klantenbestelling
      $klantenbestelling->setVerkoopprijs($totaalPrijs);

      $em->persist($klantenbestelling);

      # Klantenbestelling aanmaken en redirect als er GEEN enkele error message is
      if (!$errorMessage) {
        $em->flush();

        $this->addFlash('success', "Klantenbestelling succesvol aangemaakt!");
        $orderID = $klantenbestelling->getId();
        return $this->redirectToRoute('klantenbestellingen_show', array('id' => $orderID));
      } else {
        $this->addFlash('danger', $errorMessage);
      }
    }

    return $this->render('voorraad/artikelen_verkopen.html.twig', [
        'form' => $form->createView(),
    ]);

  }

  /**
   * @Route("/voorraad/afschrijving", name="voorraad_afschrijvingIndex")
   */
  public function afschrijvingIndex(Request $request) {
    $em = $this->getDoctrine()->getManager();

    $afschrijving = new Afschrijving();

    if ($this->get('session')->get('mode') == 'default') {
      $shishaOption = false;
    } else if ($this->get('session')->get('mode') == 'shisha') {
      $shishaOption = true;
      $afschrijving->setShishapen(true);
    }

    $form = $this->createForm(AfschrijfType::class, $afschrijving, ['shishaOption' => $shishaOption]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $errorMessage = null;

      $afschrijving->setArtikel($form->get('artikel')->getData());

      $artikel = $form->get('artikel')->getData();

      if ($artikel->getVoorraad() < $afschrijving->getAantal()) {
        $errorMessage = "Het artikel: " . $artikel->getNaam() . " heeft niet genoeg voorraad. (Huidige vooraad: " . $artikel->getVoorraad() . ")";
      }
      $artikel->setVoorraad($artikel->getVoorraad() - $afschrijving->getAantal());

      $em->persist($afschrijving);
      $em->persist($artikel);

      if (!$errorMessage) {
        $em->flush();
        $this->addFlash('success','Product succesvol afgeschreven!');
      } else {
        $this->addFlash('danger', $errorMessage);
      }

      return $this->redirectToRoute('voorraad_afschrijvingIndex');
    }

    $afschrijvingen = $em->getRepository(Afschrijving::class)->findAll();

    return $this->render('voorraad/afschrijving.html.twig', [
      'form' => $form->createView(),
      'afschrijvingen' => $afschrijvingen,
    ]);
  }

  /**
   * @Route("/voorraad/afschrijving/{id}", name="voorraad_afschrijvingShow")
   */
  public function afschrijvingShow($id) {
    $em = $this->getDoctrine()->getManager();

    $afschrijving = $em->getRepository(Afschrijving::class)->find($id);

    if (!$afschrijving) {
      throw $this->createNotFoundException('Afschrijving niet gevonden');
    }

    return $this->render('voorraad/afschrijvingshow.html.twig', [
        'afschrijving' => $afschrijving,
    ]);
  }


  public function berekenAdres($postcode, $huisnummer, $toevoegsel = null) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
// De headers worden altijd meegestuurd als array
    $headers = array();
    $headers[] = 'X-Api-Key: EeqQrrSEewAakfeR6dQ8YTUpN9p5eYakROGXSs90';

// De URL naar de API call
    $url = 'https://api.postcodeapi.nu/v2/addresses/?postcode=' . $postcode . '&number=' . $huisnummer . '&letter=' . $toevoegsel . '';

    $curl = curl_init($url);


    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// Indien de server geen TLS ondersteunt kun je met
// onderstaande optie een onveilige verbinding forceren.
// Meestal is dit probleem te herkennen aan een lege response.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// De ruwe JSON response
    $response = curl_exec($curl);
// Gebruik json_decode() om de response naar een PHP array te converteren
    $data = json_decode($response);

    $array = (array)$data;

//    var_dump($array["_embedded"]->addresses[0]->street);

//    echo "<br>";

//    var_dump($array);

    curl_close($curl);

    $this->array = $array;

  }

  public function getStraat() {
    $array = $this->array;
    return $array["_embedded"]->addresses[0]->street;
  }

  public function getStad() {
    $array = $this->array;
    return $array["_embedded"]->addresses[0]->municipality->label;
  }
}