<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * PublicProduct
 *
 * @ORM\Table(name="public_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicProductRepository")
 */
class PublicProduct {
  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="productnaam", type="string", length=255)
   */
  private $productnaam;

  /**
   * @var string
   *
   * @ORM\Column(name="beschrijving", type="text")
   */
  private $beschrijving;

  /**
   * @var int
   *
   * @ORM\Column(name="prijs", type="integer")
   */
  private $prijs;

  /**
   * @var float
   *
   * @ORM\Column(name="verzendkosten", type="float")
   */
  private $verzendkosten;

  /**
   * @var int
   *
   * @ORM\Column(name="aantal", type="integer", nullable=true)
   */
  private $aantal;

  /**
   * @ORM\Column(type="string")
   * @Assert\File(mimeTypes={"image/jpeg"})
   * @Assert\NotBlank(message="Je moet een image bestand uploaden.")
   */
  private $image;


  /**
   * Get id
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set productnaam
   *
   * @param string $productnaam
   *
   * @return PublicProduct
   */
  public function setProductnaam($productnaam) {
    $this->productnaam = $productnaam;

    return $this;
  }

  /**
   * Get productnaam
   *
   * @return string
   */
  public function getProductnaam() {
    return $this->productnaam;
  }

  /**
   * Set beschrijving
   *
   * @param string $beschrijving
   *
   * @return PublicProduct
   */
  public function setBeschrijving($beschrijving) {
    $this->beschrijving = $beschrijving;

    return $this;
  }

  /**
   * Get beschrijving
   *
   * @return string
   */
  public function getBeschrijving() {
    return $this->beschrijving;
  }

  /**
   * Set prijs
   *
   * @param integer $prijs
   *
   * @return PublicProduct
   */
  public function setPrijs($prijs) {
    $this->prijs = $prijs;

    return $this;
  }

  /**
   * Get prijs
   *
   * @return int
   */
  public function getPrijs() {
    return $this->prijs;
  }

  /**
   * Set verzendkosten
   *
   * @param float $verzendkosten
   *
   * @return PublicProduct
   */
  public function setVerzendkosten($verzendkosten) {
    $this->verzendkosten = $verzendkosten;

    return $this;
  }

  /**
   * Get verzendkosten
   *
   * @return float
   */
  public function getVerzendkosten() {
    return $this->verzendkosten;
  }

  /**
   * Set aantal
   *
   * @param integer $aantal
   *
   * @return PublicProduct
   */
  public function setAantal($aantal) {
    $this->aantal = $aantal;

    return $this;
  }

  /**
   * Get aantal
   *
   * @return int
   */
  public function getAantal() {
    return $this->aantal;
  }

  /**
   * @return mixed
   */
  public function getImage() {
    return $this->image;
  }

  /**
   * @param mixed $image
   */
  public function setImage($image) {
    $this->image = $image;
  }

}

