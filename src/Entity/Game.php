<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @var bool $multi
     */
    private $multi = false;

    /**
     * @ORM\Column(type="array")
     * @var array $players
     */
    private $players = array();

    /**
     * @ORM\Column(type="smallint")
     * @var int $duration
     */
    private $duration = 20;

    /**
     * @ORM\Column(length=10)
     * @var string $currentPlace
     */
    private $currentPlace = 'created';

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isMulti(): bool
    {
        return $this->multi;
    }

    /**
     * @param bool $multi
     */
    public function setMulti(bool $multi): void
    {
        $this->multi = $multi;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param array $players
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getCurrentPlace(): string
    {
        return $this->currentPlace;
    }

    /**
     * @param string $currentPlace
     */
    public function setCurrentPlace(string $currentPlace): void
    {
        $this->currentPlace = $currentPlace;
    }

}
