<?php

namespace App\Entity;

use App\Repository\ProspectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProspectRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Prospect
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $brithAt;

     
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $source;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $typeProspect;

    /**
     * @ORM\Column(type="string", length=255, nullable=true )
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codePost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true )
     */
    private $gsm;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $assure;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $lastAssure;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $motifResil;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="prospects")
     */
    private $autor;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="prospections")
     */
    private $comrcl;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="prospects")
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motifSaise;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatAt;

    /**
     * Permet de mettre en place la date de création
     * 
     * @ORM\PrePersist
     * 
     * @return void
     */
    public function prePersist()
    {
        if (empty($this->creatAt)) {
            $this->creatAt = new \Datetime();
        }
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
 

    public function getBrithAt(): ?\DateTimeInterface
    {
        return $this->brithAt;
    }

    public function setBrithAt(\DateTimeInterface $brithAt): self
    {
        $this->brithAt = $brithAt;

        return $this;
    }
 

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getTypeProspect(): ?string
    {
        return $this->typeProspect;
    }

    public function setTypeProspect(?string $typeProspect): self
    {
        $this->typeProspect = $typeProspect;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(?string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getCodePost(): ?int
    {
        return $this->codePost;
    }

    public function setCodePost(?int $codePost): self
    {
        $this->codePost = $codePost;

        return $this;
    }

    public function getGsm(): ?string
    {
        return $this->gsm;
    }

    public function setGsm(?string $gsm): self
    {
        $this->gsm = $gsm;

        return $this;
    }

    public function getAssure(): ?string
    {
        return $this->assure;
    }

    public function setAssure(?string $assure): self
    {
        $this->assure = $assure;

        return $this;
    }

    public function getLastAssure(): ?string
    {
        return $this->lastAssure;
    }

    public function setLastAssure(?string $lastAssure): self
    {
        $this->lastAssure = $lastAssure;

        return $this;
    }

    public function getMotifResil(): ?string
    {
        return $this->motifResil;
    }

    public function setMotifResil(?string $motifResil): self
    {
        $this->motifResil = $motifResil;

        return $this;
    }

    public function getAutor(): ?User
    {
        return $this->autor;
    }

    public function setAutor(?User $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getComrcl(): ?User
    {
        return $this->comrcl;
    }

    public function setComrcl(?User $comrcl): self
    {
        $this->comrcl = $comrcl;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getMotifSaise(): ?string
    {
        return $this->motifSaise;
    }

    public function setMotifSaise(?string $motifSaise): self
    {
        $this->motifSaise = $motifSaise;

        return $this;
    }

    public function getCreatAt(): ?\DateTimeInterface
    {
        return $this->creatAt;
    }

    public function setCreatAt(\DateTimeInterface $creatAt): self
    {
        $this->creatAt = new \DateTime();

        return $this;
    }

   
}
