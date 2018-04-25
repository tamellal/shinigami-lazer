<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     * @Assert\Length(max=6)
     */
    private $code;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="card")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Club", inversedBy="cards")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $club;

    /**
     * @ORM\Column(type="integer")
     */
    private $checkSum;

    /**
     * @ORM\Column(length=250)
     */
    private $number;

    /**
     * @ORM\Column(length=10)
     */
    private $currentPlace = 'created';

    public function getId()
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Card
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club): void
    {
        $this->club = $club;
    }

    /**
     * @return mixed
     */
    public function getCheckSum()
    {
        return $this->checkSum;
    }

    /**
     * @param mixed $checkSum
     */
    public function setCheckSum($checkSum): void
    {
        $this->checkSum = $checkSum;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     */
    public function setNumber(): void
    {
        $this->number = $this->getClub()->getCode() . $this->code . $this->checkSum;
    }

    /**
     * @return string
     */
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    /**
     * @param string $currentPlace
     */
    public function setCurrentPlace($currentPlace): void
    {
        $this->currentPlace = $currentPlace;
    }



}
