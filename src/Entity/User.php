<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, \Serializable {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=25, unique=true)
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=64)
   */
  private $password;

  /**
   * @ORM\Column(type="string", length=50, unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="json_array")
   */
  private $roles = ["ROLE_USER"];

  /**
   * @ORM\Column(name="is_active", type="boolean")
   */
  private $isActive;

  public function __construct()
  {
    $this->isActive = true;
    // may not be needed, see section on salt below
    // $this->salt = md5(uniqid('', true));
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function getSalt()
  {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
  }

  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @return mixed
   */
  public function getRoles() {
    return $this->roles;
  }



  public function eraseCredentials()
  {
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @param mixed $username
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }

  /**
   * @param mixed $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }

  /**
   * @param mixed $email
   */
  public function setEmail($email)
  {
    $this->email = $email;
  }

  /**
   * @param mixed $isActive
   */
  public function setIsActive($isActive)
  {
    $this->isActive = $isActive;
  }



  /** @see \Serializable::serialize() */
  public function serialize()
  {
    return serialize(array(
        $this->id,
        $this->username,
        $this->password,
      // see section on salt below
      // $this->salt,
    ));
  }

  /** @see \Serializable::unserialize() */
  public function unserialize($serialized)
  {
    list (
        $this->id,
        $this->username,
        $this->password,
        // see section on salt below
        // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
  }



}