<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="opmerking")
 */
class Opmerking {

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
   * @ORM\Column(type="string")
   * @Assert\NotBlank(message="Dit veld kan niet leeg zijn!")
   */
  private $opmerking;
  /**
   * @ORM\Column(type="boolean")
   */
  private $voltooid = false;
  /**
   * @ORM\Column(type="date")
   */
  private $datum;
  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $datumvoltooid = null;

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
  public function getOpmerking() {
    return $this->opmerking;
  }

  /**
   * @param mixed $opmerking
   */
  public function setOpmerking($opmerking): void {
    $this->opmerking = $opmerking;
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
  public function setVoltooid($voltooid): void {
    $this->voltooid = $voltooid;
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
  public function getDatumvoltooid() {
    return $this->datumvoltooid;
  }

  /**
   * @param mixed $datumvoltooid
   */
  public function setDatumvoltooid($datumvoltooid): void {
    $this->datumvoltooid = $datumvoltooid;
  }


}