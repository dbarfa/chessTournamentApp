<?php

namespace App\Entity;

use App\Enumeration\SexEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private $firstName;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private $lastName;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    private $birthDate;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $elo;

    #[ORM\Column(type: 'string', enumType: SexEnum::class)]
    #[Assert\NotBlank]
    private $sex;

    #[ORM\Column(type: 'string',nullable: true)]
    private $pic;


    #[ORM\ManyToMany(targetEntity: Role::class)]
    private $roles;

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\ManyToMany(targetEntity: Tournament::class, mappedBy: 'players')]
    private $tournaments;

    #[ORM\OneToMany(mappedBy: 'white', targetEntity: Matches::class)]
    private $whiteMatches;

    #[ORM\OneToMany(mappedBy: 'black', targetEntity: Matches::class)]
    private $blackMatches;



    public function __construct()
    {
        $this->tournaments = new ArrayCollection();
        $this->whiteMatches = new ArrayCollection();
        $this->blackMatches = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];
        // guarantee every user at least has ROLE_USER
        foreach ($this->roles as $role){
            $roles[] = $role->getLabel();
        }
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getElo()
    {
        return $this->elo;
    }

    /**
     * @param mixed $elo
     * @return User
     */
    public function setElo($elo)
    {
        $this->elo = $elo;
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
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * @param mixed $pic
     * @return User
     */
    public function setPic($pic)
    {
        $this->pic = $pic;
        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments[] = $tournament;
            $tournament->addPlayer($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getWhiteMatches(): Collection
    {
        return $this->whiteMatches;
    }

    public function addWhiteMatch(Matches $whiteMatch): self
    {
        if (!$this->whiteMatches->contains($whiteMatch)) {
            $this->whiteMatches[] = $whiteMatch;
            $whiteMatch->setWhite($this);
        }

        return $this;
    }

    public function removeWhiteMatch(Matches $whiteMatch): self
    {
        if ($this->whiteMatches->removeElement($whiteMatch)) {
            // set the owning side to null (unless already changed)
            if ($whiteMatch->getWhite() === $this) {
                $whiteMatch->setWhite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getBlackMatches(): Collection
    {
        return $this->blackMatches;
    }

    public function addBlackMatch(Matches $blackMatch): self
    {
        if (!$this->blackMatches->contains($blackMatch)) {
            $this->blackMatches[] = $blackMatch;
            $blackMatch->setBlack($this);
        }

        return $this;
    }

    public function removeBlackMatch(Matches $blackMatch): self
    {
        if ($this->blackMatches->removeElement($blackMatch)) {
            // set the owning side to null (unless already changed)
            if ($blackMatch->getBlack() === $this) {
                $blackMatch->setBlack(null);
            }
        }

        return $this;
    }



}
