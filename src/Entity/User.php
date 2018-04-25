<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, errorPath="email", message="Ce compte existe déjà !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(length=50)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(length=50)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(length=50)
     * @Assert\NotBlank()
     */
    private $nickname;

    /**
     * @ORM\Column(length=150, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $birthdate;

    /**
     * @ORM\Column(length=50, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(length=65)
     */
    private $password;

    /**
     * @ORM\Column(length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $signUpDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $lastConnexionDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $lastModificationDate;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Card", mappedBy="user")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $card;


    /**
     * @ORM\Column(length=250, nullable=true)
     */
    private $token;

    /**
     * User constructor.
     */
    public function __construct()
    {
        # Valeur pas defaut
        $now = new \DateTime();
        $this->signUpDate = $now;
        $this->lastModificationDate = $now;
        $this->lastConnexionDate = $now;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     * @return User
     */
    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return User
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param \datetime $birthdate
     * @return User
     */
    public function setBirthdate(\datetime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return User
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignUpDate()
    {
        return $this->signUpDate;
    }

    /**
     * @param mixed $signUpDate
     */
    public function setSignUpDate($signUpDate): void
    {
        $this->signUpDate = $signUpDate;
    }

    /**
     * @return mixed
     */
    public function getLastConnexionDate()
    {
        return $this->lastConnexionDate;
    }

    /**
     * @param mixed $lastConnexionDate
     */
    public function setLastConnexionDate($lastConnexionDate): void
    {
        $this->lastConnexionDate = $lastConnexionDate;
    }

    /**
     * @return mixed
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }

    /**
     * @param mixed $lastModificationDate
     */
    public function setLastModificationDate($lastModificationDate): void
    {
        $this->lastModificationDate = $lastModificationDate;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles[] = $roles;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card): void
    {
        $this->card = $card;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }


}
