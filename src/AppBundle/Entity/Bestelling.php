<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BestellingRepository")
 * @ORM\Table(name="bestelling")
 */
class Bestelling {

  public function __construct() {
    $this->datum = new \DateTime();
  }

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="bestellingartikel")
   * @ORM\JoinColumn(name="artikel_id", referencedColumnName="id", nullable=true)
   */
  private $artikel;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $naam = null;
  /**
   * @ORM\Column(type="integer")
   * @Assert\NotBlank(message="Dit veld kan niet leeg zijn!")
   */
  private $aantal;
  /**
   * @ORM\Column(type="float")
   * @Assert\NotBlank(message="Dit veld kan niet leeg zijn!")
   */
  private $bedrag;
  /**
   * @ORM\Column(type="float")
   */
  private $korting = 0;
  /**
   * @ORM\Column(type="date")
   */
  private $datum;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $extraInfo;
  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $ontvangstdatum = null;
  /**
   * @ORM\Column(type="boolean")
   */
  private $ontvangen = false;
  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $customName = false;
  /**
   * @ORM\Column(type="boolean")
   */
  private $shishapen = false;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id): void {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function getArtikel() {
    return $this->artikel;
  }

  /**
   * @param mixed $artikel
   */
  public function setArtikel(Artikel $artikel): void {
    $this->artikel = $artikel;
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
  public function setNaam($naam): void {
    $this->naam = $naam;
  }

  /**
   * @return mixed
   */
  public function getAantal() {
    return $this->aantal;
  }

  /**
   * @param mixed $aantal
   */
  public function setAantal($aantal): void {
    $this->aantal = $aantal;
  }

  /**
   * @return mixed
   */
  public function getBedrag() {
    return $this->bedrag;
  }

  /**
   * @param mixed $bedrag
   */
  public function setBedrag($bedrag): void {
    $this->bedrag = $bedrag;
  }

  /**
   * @return mixed
   */
  public function getKorting() {
    return $this->korting;
  }

  /**
   * @param mixed $korting
   */
  public function setKorting($korting): void {
    $this->korting = $korting;
  }

  /**
   * @return mixed
   */
  public function getDatum() {
    return $this->datum;
  }

  /**
   * @param mixed $datum
   */
  public function setDatum($datum): void {
    $this->datum = $datum;
  }

  /**
   * @return mixed
   */
  public function getExtraInfo() {
    return $this->extraInfo;
  }

  /**
   * @param mixed $extraInfo
   */
  public function setExtraInfo($extraInfo): void {
    $this->extraInfo = $extraInfo;
  }

  /**
   * @return mixed
   */
  public function getOntvangstdatum() {
    return $this->ontvangstdatum;
  }

  /**
   * @param mixed $ontvangstdatum
   */
  public function setOntvangstdatum($ontvangstdatum): void {
    $this->ontvangstdatum = $ontvangstdatum;
  }

  /**
   * @return mixed
   */
  public function getOntvangen() {
    return $this->ontvangen;
  }

  /**
   * @param mixed $ontvangen
   */
  public function setOntvangen($ontvangen): void {
    $this->ontvangen = $ontvangen;
  }

  /**
   * @return mixed
   */
  public function getCustomName() {
    return $this->customName;
  }

  /**
   * @param mixed $customName
   */
  public function setCustomName($customName): void {
    $this->customName = $customName;
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
  public function setShishapen($shishapen): void {
    $this->shishapen = $shishapen;
  }

}