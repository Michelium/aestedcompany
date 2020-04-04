<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="afschrijving")
 */
class Afschrijving {

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
   * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="afschrijvingartikel")
   * @ORM\JoinColumn(name="artikel_id", referencedColumnName="id")
   */
  private $artikel;
  /**
   * @ORM\Column(type="integer")
   */
  private $aantal;
  /**
   * @ORM\Column(type="string")
   */
  private $reden;
  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $reden_text = null;
  /**
   * @ORM\Column(type="datetime")
   */
  private $datum;
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
  public function setId($id) {
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
  public function getAantal() {
    return $this->aantal;
  }

  /**
   * @param mixed $aantal
   */
  public function setAantal($aantal) {
    $this->aantal = $aantal;
  }

  /**
   * @return mixed
   */
  public function getReden() {
    return $this->reden;
  }

  /**
   * @param mixed $reden
   */
  public function setReden($reden) {
    $this->reden = $reden;
  }

  /**
   * @return mixed
   */
  public function getRedenText() {
    return $this->reden_text;
  }

  /**
   * @param mixed $reden_text
   */
  public function setRedenText($reden_text) {
    $this->reden_text = $reden_text;
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