<?php

namespace App\Entity;

use ORM\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection; 
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * * @Assert\NotBlank(
     *     message="Le nom d'utilisateur est obligatoire"
     * )
     * @Assert\Length(
     *     min=4,
     *     max=15,
     *     minMessage="Votre nom d'utilisateur doit contenir au moins quatre caractères",
     *     maxMessage="Votre nom d'utilisateur doit contenir au maximum quinze caractères"
     * )
     * 
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min=2,
     *      max=10,
     *      minMessage="Votre prénom doit contenir au moins deux caractères",
     *      maxMessage="Votre prénom doit contenir au maximum dix caractères"
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min=2,
     *     max=10,
     *     minMessage="Votre nom doit contenir au moins deux caractères",
     *     maxMessage="Votre nom doit contenir au maximum dix caractères"
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $embuchAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remuneration;

    /**
     * @ORM\ManyToMany(targetEntity=Fonction::class, inversedBy="users", cascade={"persist"})
     */
    private $fonctions;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = true;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="users", cascade={"persist"})
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=Prospect::class, mappedBy="autor")
     */
    private $prospects;

    /**
     * @ORM\OneToMany(targetEntity=Prospect::class, mappedBy="comrcl")
     * @ORM\JoinColumn(nullable=true)
     */
    private $prospections;

    
     

    public function __construct()
    {
        $this->fonctions = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->prospects = new ArrayCollection();
        $this->prospections = new ArrayCollection();
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
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
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ADMIN';

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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmbuchAt(): ?\DateTimeInterface
    {
        return $this->embuchAt;
    }

    public function setEmbuchAt(\DateTimeInterface $embuchAt): self
    {
        $this->embuchAt = $embuchAt;

        return $this;
    }

    public function getRemuneration(): ?int
    {
        return $this->remuneration;
    }

    public function setRemuneration(int $remuneration): self
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    /**
     * @return Collection<int, Fonction>
     */
    public function getFonctions(): Collection
    {
        return $this->fonctions;
    }

    public function addFonction(Fonction $fonction): self
    {
        if (!$this->fonctions->contains($fonction)) {
            $this->fonctions[] = $fonction;
            $fonction->addUser($this);
        }

        return $this;
    }

    public function removeFonction(Fonction $fonction): self
    {
        if ($this->fonctions->removeElement($fonction)) {
            $fonction->removeUser($this);
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTeams(): ?Team
    {
        return $this->teams;
    }

    public function setTeams(?Team $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    
   


    public function __toString()
    {
       return strval( $this->getUserIdentifier() );
    }

    /**
     * @return Collection<int, Prospect>
     */
    public function getProspects(): Collection
    {
        return $this->prospects;
    }

    public function addProspect(Prospect $prospect): self
    {
        if (!$this->prospects->contains($prospect)) {
            $this->prospects[] = $prospect;
            $prospect->setAutor($this);
        }

        return $this;
    }

    public function removeProspect(Prospect $prospect): self
    {
        if ($this->prospects->removeElement($prospect)) {
            // set the owning side to null (unless already changed)
            if ($prospect->getAutor() === $this) {
                $prospect->setAutor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prospect>
     */
    public function getProspections(): Collection
    {
        return $this->prospections;
    }

    public function addProspection(Prospect $prospection): self
    {
        if (!$this->prospections->contains($prospection)) {
            $this->prospections[] = $prospection;
            $prospection->setComrcl($this);
        }

        return $this;
    }

    public function removeProspection(Prospect $prospection): self
    {
        if ($this->prospections->removeElement($prospection)) {
            // set the owning side to null (unless already changed)
            if ($prospection->getComrcl() === $this) {
                $prospection->setComrcl(null);
            }
        }

        return $this;
    }


    //  /**
    //  * @return int
    //  */
    // public function getProspectCount(): int
    // {
    //     // Utilisez la méthode count() de la collection prospects pour obtenir le nombre de prospects
    //     return $this->prospects->count();
    // }

}
