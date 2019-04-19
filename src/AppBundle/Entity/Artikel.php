<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="artikel")
 */
class Artikel {

  public function __construct() {
    $this->klantenbestellingartikel = new ArrayCollection();
    $this->bestellingartikel = new ArrayCollection();
  }

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank(message="Naam veld kan niet leeg zijn!"))
   */
  private $naam;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $categorie = null;
  /**
   * @ORM\Column(type="integer")
   */
  private $voorraad = 0;
  /**
   * @ORM\Column(type="integer")
   */
  private $afzet = 0;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $inkoopprijs = null;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $gewicht = null;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $minimaleVerkoopprijs = null;
  /**
   * @ORM\Column(type="float", nullable=true)
   */
  private $adviesprijs = null;
  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $minimaleVoorraad = null;
  /**
   * @ORM\Column(type="integer")
   */
  private $populariteit = 0;
  /**
   * @ORM\Column(type="boolean")
   */
  private $shishapen = false;
  /**
   * @ORM\OneToMany(targetEntity="KlantenbestellingArtikel", mappedBy="artikel")
   */
  private $klantenbestellingartikel;
  /**
   * @ORM\OneToMany(targetEntity="Bestelling", mappedBy="artikel")
   */
  private $bestellingartikel;
  /**
   * @ORM\OneToMany(targetEntity="Afschrijving", mappedBy="artikel")
   */
  private $afschrijvingartikel;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getNaam() {
    return $this->naam;
  }

  /**
   * @param mixed $naam
   */
  public function setNaam($naam) {
    $this->naam = $naam;
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
  public function getVoorraad() {
    return $this->voorraad;
  }

  /**
   * @param mixed $voorraad
   */
  public function setVoorraad($voorraad) {
    $this->voorraad = $voorraad;
  }

  /**
   * @return mixed
   */
  public function getAfzet() {
    return $this->afzet;
  }

  /**
   * @param mixed $afzet
   */
  public function setAfzet($afzet) {
    $this->afzet = $afzet;
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
  public function getShishapen() {
    return $this->shishapen;
  }

  /**
   * @param mixed $shishapen
   */
  public function setShishapen($shishapen) {
    $this->shishapen = $shishapen;
  }

  /*
   * FUNCTIONS
   */

  public function canBeSold($aantal) {
    return $aantal <= $this->getVoorraad();
  }
}