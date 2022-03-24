<?php

namespace App\Entity;

use App\Enumeration\WinnerEnum;
use App\Repository\MatchesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: 'matches')]
    private $tournamentId;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'matches')]
    private $whiteId;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'matches')]
    private $blackId;

    #[ORM\Column(type: 'string', enumType: WinnerEnum::class)]
    private $winner;

    public function __construct()
    {
        $this->whiteId = new ArrayCollection();
        $this->blackId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournamentId(): ?Tournament
    {
        return $this->tournamentId;
    }

    public function setTournamentId(?Tournament $tournamentId): self
    {
        $this->tournamentId = $tournamentId;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getWhiteId(): Collection
    {
        return $this->whiteId;
    }

    public function addWhiteId(User $whiteId): self
    {
        if (!$this->whiteId->contains($whiteId)) {
            $this->whiteId[] = $whiteId;
        }

        return $this;
    }

    public function removeWhiteId(User $whiteId): self
    {
        $this->whiteId->removeElement($whiteId);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getBlackId(): Collection
    {
        return $this->blackId;
    }

    public function addBlackId(User $blackId): self
    {
        if (!$this->blackId->contains($blackId)) {
            $this->blackId[] = $blackId;
        }

        return $this;
    }

    public function removeBlackId(User $blackId): self
    {
        $this->blackId->removeElement($blackId);

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
