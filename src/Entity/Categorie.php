<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorie")
 */
class Categorie {
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
  private $naam;

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
  public function getId() {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  public function __toString() {
   return $this->getNaam();
  }
}