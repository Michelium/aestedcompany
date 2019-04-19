<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product {
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $productnaam;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $categorie;
  /**
   * @ORM\Column(type="integer")
   */
  private $aantalvoorraad = 0;
  /**
   * @ORM\Column(type="integer")
   */
  private $aantalverkocht = 0;
  /**
   * @ORM\Column(type="float")
   */
  private $omzet = 0;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $inkoopprijs = 0;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $gewicht = null;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $minimaleVerkoopprijs = 0;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $adviesprijs = 0;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $minimaleVoorraad = 0;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $populariteit = 0;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $smaak = null;
  /**
   * @ORM\Column(type="boolean")
   */
  private $shishapen = false;
  /**
   * @ORM\OneToMany(targetEntity="Afschrijving", mappedBy="product")
   */
  private $afschrijvingProduct;
  private $besteld = false;


  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getProductnaam() {
    return $this->productnaam;
  }

  /**
   * @param mixed $productnaam
   */
  public function setProductnaam($productnaam) {
    $this->productnaam = $productnaam;
  }

  /**
   * @return mixed
   */
  public function getCategorie() {
    return $this->categorie;
  }

  /**
   * @param mixed $categorie
   */
  public function setCategorie($categorie) {
    $this->categorie = $categorie;
  }

  /**
   * @return mixed
   */
  public function getAantalvoorraad() {
    return $this->aantalvoorraad;
  }

  /**
   * @param mixed $aantalvoorraad
   */
  public function setAantalvoorraad($aantalvoorraad) {
    $this->aantalvoorraad = $aantalvoorraad;
  }

  /**
   * @return mixed
   */
  public function getAantalverkocht() {
    return $this->aantalverkocht;
  }

  /**
   * @param mixed $aantalverkocht
   */
  public function setAantalverkocht($aantalverkocht) {
    $this->aantalverkocht = $aantalverkocht;
  }

  /**
   * @return mixed
   */
  public function getOmzet() {
    return $this->omzet;
  }

  /**
   * @param mixed $omzet
   */
  public function setOmzet($omzet) {
    $this->omzet = $omzet;
  }

  /**
   * @return mixed
   */
  public function getInkoopprijs() {
    return $this->inkoopprijs;
  }

  /**
   * @param mixed $inkoopprijs
   */
  public function setInkoopprijs($inkoopprijs) {
    $this->inkoopprijs = $inkoopprijs;
  }

  /**
   * @return mixed
   */
  public function getGewicht() {
    return $this->gewicht;
  }

  /**
   * @param mixed $gewicht
   */
  public function setGewicht($gewicht) {
    $this->gewicht = $gewicht;
  }

  /**
   * @return mixed
   */
  public function getMinimaleVerkoopprijs() {
    return $this->minimaleVerkoopprijs;
  }

  /**
   * @param mixed $minimaleVerkoopprijs
   */
  public function setMinimaleVerkoopprijs($minimaleVerkoopprijs) {
    $this->minimaleVerkoopprijs = $minimaleVerkoopprijs;
  }

  /**
   * @return mixed
   */
  public function getAdviesprijs() {
    return $this->adviesprijs;
  }

  /**
   * @param mixed $adviesprijs
   */
  public function setAdviesprijs($adviesprijs) {
    $this->adviesprijs = $adviesprijs;
  }

  /**
   * @return mixed
   */
  public function getMinimaleVoorraad() {
    return $this->minimaleVoorraad;
  }

  /**
   * @param mixed $minimaleVoorraad
   */
  public function setMinimaleVoorraad($minimaleVoorraad) {
    $this->minimaleVoorraad = $minimaleVoorraad;
  }

  /**
   * @return mixed
   */
  public function getPopulariteit() {
    return $this->populariteit;
  }

  /**
   * @param mixed $populariteit
   */
  public function setPopulariteit($populariteit) {
    $this->populariteit = $populariteit;
  }

  /**
   * @return mixed
   */
  public function getSmaak() {
    return $this->smaak;
  }

  /**
   * @param mixed $smaak
   */
  public function setSmaak($smaak) {
    $this->smaak = $smaak;
  }

  /**
   * @return mixed
   */
  public function getShishapen() {
    return $this->shishapen;
  }

  /**
   * @param mixed $shishapen
   */
  public function setShishapen($shishapen) {
    $this->shishapen = $shishapen;
  }

  /**
   * @return bool
   */
  public function isBesteld() {
    return $this->besteld;
  }

  /**
   * @param bool $besteld
   */
  public function setBesteld($besteld) {
    $this->besteld = $besteld;
  }

  /*
   * FUNCTIONS
   */

  public function canBeSold($aantal) {
    return $aantal <= $this->getAantalvoorraad();
  }

  /**
   * @return mixed
   */
  public function getOrderProduct() {
    return $this->orderProduct;
  }

  /**
   * @return mixed
   */
  public function getAfschrijvingProduct() {
    return $this->afschrijvingProduct;
  }



}