<?php

namespace App\Entity;

use App\Enumeration\AgeCategoryEnum;
use App\Enumeration\SexEnum;
use App\Enumeration\TournTypeEnum;
use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\Column(type: 'boolean')]
    private $rated;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $eloMin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $eloMax;

    #[ORM\Column(type: 'string',enumType: AgeCategoryEnum::class)]
    private $ageCat;

    #[ORM\Column(type: 'string',enumType: SexEnum::class)]
    private $sex;

    #[ORM\Column(type: 'string',enumType: TournTypeEnum::class)]
    private $type;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nrMin;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nrMax;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tournaments')]
    private $players;

    #[ORM\Column(type: 'boolean',options: ['default' => 0])]
    private $deleted;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Tournament
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getRated(): ?bool
    {
        return $this->rated;
    }

    public function setRated(bool $rated): self
    {
        $this->rated = $rated;

        return $this;
    }

    public function getEloMin(): ?int
    {
        return $this->eloMin;
    }

    public function setEloMin(?int $eloMin): self
    {
        $this->eloMin = $eloMin;

        return $this;
    }

    public function getEloMax(): ?int
    {
        return $this->eloMax;
    }

    public function setEloMax(?int $eloMax): self
    {
        $this->eloMax = $eloMax;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgeCat()
    {
        return $this->ageCat;
    }

    /**
     * @param mixed $ageCat
     * @return Tournament
     */
    public function setAgeCat($ageCat)
    {
        $this->ageCat = $ageCat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     * @return Tournament
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Tournament
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }







    public function getNrMin(): ?int
    {
        return $this->nrMin;
    }

    public function setNrMin(?int $nrMin): self
    {
        $this->nrMin = $nrMin;

        return $this;
    }

    public function getNrMax(): ?int
    {
        return $this->nrMax;
    }

    public function setNrMax(?int $nrMax): self
    {
        $this->nrMax = $nrMax;

        return $this;
    }

    /**
     * @return PersistentCollection
     */
    public function getPlayers(): PersistentCollection
    {
        return $this->players;
    }

    public function addPlayer(User $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer(User $player): self
    {
        $this->players->removeElement($player);

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
