<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="klantenbestelling_artikel")
 */
class KlantenbestellingArtikel {

  /**
   * @ORM\Id()
   * @ORM\ManyToOne(targetEntity="Klantenbestelling", inversedBy="klantenbestellingartikel")
   * @ORM\JoinColumn(name="klantenbestelling_id", referencedColumnName="id", nullable=false)
   */
  private $klantenbestelling;

  /**
   * @ORM\Id()
   * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="klantenbestellingartikel")
   * @ORM\JoinColumn(name="artikel_id", referencedColumnName="id", nullable=false)
   */
  private $artikel;

  /**
   * @ORM\Column(type="integer")
   */
  private $aantal;

  /**
   * @return mixed
   */
  public function getKlantenbestelling() {
    return $this->klantenbestelling;
  }


  /**
   * @param mixed $klantenbestelling
   */
  public function setKlantenbestelling(Klantenbestelling $klantenbestelling) {
    $this->klantenbestelling = $klantenbestelling;
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
  public function setArtikel(Artikel $artikel) {
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



}