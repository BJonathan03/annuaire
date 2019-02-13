<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitorRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"vendor" = "Vendor", "client" = "Client"})
 * @UniqueEntity(
 *     fields={"email"},
 *     message="un autre utilisateur s'est déjà inscrit avec cette adresse email, merci de la modifier"
 * )
 */
abstract class Visitor implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Vous devez renseigner votre adresse")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Vous devez renseigner le numéro de votre maison")
     */
    private $number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Veuillez donner un email valide !")
     *
     */
    protected $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscription;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au moins 8 caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $try;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cp", inversedBy="visitors")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $cp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality", inversedBy="visitors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $locality;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initialize(){
        $this->banni = 1;
        $this->date = new \DateTime('now');
        $this->inscription = 0;
        $this->try = 0;

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBanni(): ?bool
    {
        return $this->banni;
    }

    public function setBanni(bool $banni): self
    {
        $this->banni = $banni;

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

    public function getInscription(): ?bool
    {
        return $this->inscription;
    }

    public function setInscription(bool $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTry(): ?int
    {
        return $this->try;
    }

    public function setTry(int $try): self
    {
        $this->try = $try;

        return $this;
    }

    public function getCp(): ?Cp
    {
        return $this->cp;
    }

    public function setCp(?Cp $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getRoles()
    {
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


}
