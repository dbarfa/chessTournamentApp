<?php

namespace App\Entity;

use App\Enumeration\WinnerEnum;
use App\Repository\MatchesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private $tournament;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'whiteMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private $white;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'blackMatches')]
    #[ORM\JoinColumn(nullable: false)]
    private $black;

    #[ORM\Column(type: 'string', enumType: WinnerEnum::class)]
    private $winner;

    #[ORM\Column(type: 'integer')]
    private $round;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * @param mixed $round
     * @return Matches
     */
    public function setRound($round)
    {
        $this->round = $round;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param mixed $tournament
     * @return Matches
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWhite()
    {
        return $this->white;
    }

    /**
     * @param mixed $white
     * @return Matches
     */
    public function setWhite($white)
    {
        $this->white = $white;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlack()
    {
        return $this->black;
    }

    /**
     * @param mixed $black
     * @return Matches
     */
    public function setBlack($black)
    {
        $this->black = $black;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param mixed $winner
     * @return Matches
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;
        return $this;
    }

}
