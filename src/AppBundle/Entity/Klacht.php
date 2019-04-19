<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="klacht")
 */
class Klacht {

  public function __construct() {
    $this->datumingediend = new \DateTime();
  }

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;
  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank(message="Dit veld kan niet leeg zijn!")
   */
  private $klachtText;
  /**
   * @ORM\Column(type="boolean")
   */
  private $voltooid = false;
  /**
   * @ORM\Column(type="date")
   */
  private $datumingediend;
  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $datumvoltooid = null;

  /**
   * @return mixed
   */
  public function getKlachtText() {
    return $this->klachtText;
  }

  /**
   * @param mixed $klachtText
   */
  public function setKlachtText($klachtText) {
    $this->klachtText = $klachtText;
  }

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
  public function getVoltooid() {
    return $this->voltooid;
  }

  /**
   * @param mixed $voltooid
   */
  public function setVoltooid($voltooid) {
    $this->voltooid = $voltooid;
  }

  /**
   * @return mixed
   */
  public function getDatumingediend() {
    return $this->datumingediend;
  }

  /**
   * @param mixed $datumingediend
   */
  public function setDatumingediend($datumingediend) {
    $this->datumingediend = $datumingediend;
  }

  /**
   * @return mixed
   */
  public function getDatumvoltooid() {
    return $this->datumvoltooid;
  }

  /**
   * @param mixed $datumvoltooid
   */
  public function setDatumvoltooid($datumvoltooid) {
    $this->datumvoltooid = $datumvoltooid;
  }


}