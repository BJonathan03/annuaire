<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VendorRepository")
 * @ORM\Table(name="vendor")
 */
class Vendor extends Visitor
{
    /*
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
/*
    private $id;
*/
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner votre prénom")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez renseigner votre numéro de téléphone")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tva;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Veuillez renseigner votre email de contact")
     */
    private $emailContact;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Service", inversedBy="vendors")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="vendor")
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="vendor")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="logo")
     */
    private $logos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="pictures")
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="vendor", orphanRemoval=true)
     */
    private $stage;


    public function __construct()
    {
        $this->service = new ArrayCollection();
        $this->logo = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->logos = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->stage = new ArrayCollection();

    }
/*
    public function getId(): ?int
    {
        return $this->id;
    }
*/
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->service->contains($service)) {
            $this->service->removeElement($service);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection|Image[]
     */
    public function getLogo(): Collection
    {
        return $this->logo;
    }

    public function addLogo(Image $logo): self
    {
        if (!$this->logo->contains($logo)) {
            $this->logo[] = $logo;
            $logo->setVendor($this);
        }

        return $this;
    }

    public function removeLogo(Image $logo): self
    {
        if ($this->logo->contains($logo)) {
            $this->logo->removeElement($logo);
            // set the owning side to null (unless already changed)
            if ($logo->getVendor() === $this) {
                $logo->setVendor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVendor($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getVendor() === $this) {
                $image->setVendor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    /**
     * @return Collection|Image[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Image $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setPictures($this);
        }

        return $this;
    }

    public function removePicture(Image $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getPictures() === $this) {
                $picture->setPictures(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStage(): Collection
    {
        return $this->stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stage->contains($stage)) {
            $this->stage[] = $stage;
            $stage->setVendor($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stage->contains($stage)) {
            $this->stage->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getVendor() === $this) {
                $stage->setVendor(null);
            }
        }

        return $this;
    }

}
