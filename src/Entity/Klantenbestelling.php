<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 * @ORM\Table(name="klantenbestelling")
 */
class Klantenbestelling{

  public function __construct() {
    $this->verkoopDatum = new \DateTime();
    $this->klantenbestellingartikel = new ArrayCollection();
  }

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank(message="Koper veld kan niet leeg zijn!")
   */
  private $koper;

  /**
   * @ORM\Column(type="float")
   * @Assert\NotBlank(message="Verkoopprijs kan niet leeg zijn!")
   */
  private $verkoopprijs = 0;

  /**
   * @ORM\Column(type="date")
   */
  private $verkoopDatum;

  /**
   * @ORM\Column(type="boolean")
   */
  private $verkocht = true;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $verzonden = false;

  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $verwachteLeverdatum;

  /**
   * @ORM\Column(type="text", nullable=true)
   */
  private $extraInfo = null;

  /**
   * @ORM\Column(type="integer")
   */
  private $postzegels = 0;

  /**
   * @ORM\Column(type="string")
   */
  private $betaalmethode = "Niet beschikbaar";

  /**
   * @ORM\Column(type="boolean")
   */
  private $betaald = false;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $postcode = null;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $huisnummer = null;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $adres = null;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $toevoegsel = null;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $stad = null;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  private $totaalgewicht;

  /**
   * @ORM\Column(type="boolean")
   */
  private $shishapen = false;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $marktplaatsaccount = null;

  /**
   * @ORM\OneToMany(targetEntity="KlantenbestellingArtikel", mappedBy="klantenbestelling")
   */
  private $klantenbestellingartikel;

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
  public function getKoper() {
    return $this->koper;
  }

  /**
   * @param mixed $koper
   */
  public function setKoper($koper) {
    $this->koper = $koper;
  }

  /**
   * @return mixed
   */
  public function getVerkoopprijs() {
    return $this->verkoopprijs;
  }

  /**
   * @param mixed $verkoopprijs
   */
  public function setVerkoopprijs($verkoopprijs) {
    $this->verkoopprijs = $verkoopprijs;
  }

  /**
   * @return mixed
   */
  public function getVerkoopDatum() {
    return $this->verkoopDatum;
  }

  /**
   * @param mixed $verzendkosten
   */
  public function setVerzendkosten($verzendkosten) {
    $this->verzendkosten = $verzendkosten;
  }

  /**
   * @return mixed
   */
  public function getVerkocht() {
    return $this->verkocht;
  }

  /**
   * @param mixed $verkocht
   */
  public function setVerkocht($verkocht) {
    $this->verkocht = $verkocht;
  }

  /**
   * @return mixed
   */
  public function getVerzonden() {
    return $this->verzonden;
  }

  /**
   * @param mixed $verzonden
   */
  public function setVerzonden($verzonden) {
    $this->verzonden = $verzonden;
  }

  /**
   * @return mixed
   */
  public function getVerwachteLeverdatum() {
    return $this->verwachteLeverdatum;
  }

  /**
   * @param mixed $verwachteLeverdatum
   */
  public function setVerwachteLeverdatum($verwachteLeverdatum) {
    $this->verwachteLeverdatum = $verwachteLeverdatum;
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
  public function setExtraInfo($extraInfo) {
    $this->extraInfo = $extraInfo;
  }

  /**
   * @return mixed
   */
  public function getPostzegels() {
    return $this->postzegels;
  }

  /**
   * @param mixed $postzegels
   */
  public function setPostzegels($postzegels) {
    $this->postzegels = $postzegels;
  }

  /**
   * @return mixed
   */
  public function getBetaalmethode() {
    return $this->betaalmethode;
  }

  /**
   * @param mixed $betaalmethode
   */
  public function setBetaalmethode($betaalmethode) {
    $this->betaalmethode = $betaalmethode;
  }

  /**
   * @return mixed
   */
  public function getBetaald() {
    return $this->betaald;
  }

  /**
   * @param mixed $betaald
   */
  public function setBetaald($betaald) {
    $this->betaald = $betaald;
  }

  /**
   * @return mixed
   */
  public function getPostcode() {
    return $this->postcode;
  }

  /**
   * @param mixed $postcode
   */
  public function setPostcode($postcode) {
    $this->postcode = $postcode;
  }

  /**
   * @return mixed
   */
  public function getHuisnummer() {
    return $this->huisnummer;
  }

  /**
   * @param mixed $huisnummer
   */
  public function setHuisnummer($huisnummer) {
    $this->huisnummer = $huisnummer;
  }

  /**
   * @return mixed
   */
  public function getAdres() {
    return $this->adres;
  }

  /**
   * @param mixed $adres
   */
  public function setAdres($adres) {
    $this->adres = $adres;
  }

  /**
   * @return mixed
   */
  public function getToevoegsel() {
    return $this->toevoegsel;
  }

  /**
   * @param mixed $toevoegsel
   */
  public function setToevoegsel($toevoegsel) {
    $this->toevoegsel = $toevoegsel;
  }

  /**
   * @return mixed
   */
  public function getStad() {
    return $this->stad;
  }

  /**
   * @param mixed $stad
   */
  public function setStad($stad) {
    $this->stad = $stad;
  }

  /**
   * @return mixed
   */
  public function getTotaalgewicht() {
    return $this->totaalgewicht;
  }

  /**
   * @param mixed $totaalgewicht
   */
  public function setTotaalgewicht($totaalgewicht) {
    $this->totaalgewicht = $totaalgewicht;
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
   * @return mixed
   */
  public function getMarktplaatsaccount() {
    return $this->marktplaatsaccount;
  }

  /**
   * @param mixed $marktplaatsaccount
   */
  public function setMarktplaatsaccount($marktplaatsaccount) {
    $this->marktplaatsaccount = $marktplaatsaccount;
  }

  /**
   * @return mixed
   */
  public function getKlantenbestellingartikel() {
    return $this->klantenbestellingartikel;
  }

  /**
   * @param mixed $klantenbestellingartikel
   */
  public function setKlantenbestellingartikel($klantenbestellingartikel) {
    $this->klantenbestellingartikel = $klantenbestellingartikel;
  }









}