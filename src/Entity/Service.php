<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $front;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vendor", mappedBy="service")
     */
    private $vendors;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     */
    private $photo;

    public function __construct()
    {
        $this->vendors = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFront(): ?bool
    {
        return $this->front;
    }

    public function setFront(bool $front): self
    {
        $this->front = $front;

        return $this;
    }

    public function getValidity(): ?bool
    {
        return $this->validity;
    }

    public function setValidity(bool $validity): self
    {
        $this->validity = $validity;

        return $this;
    }

    /**
     * @return Collection|Vendor[]
     */
    public function getVendors(): Collection
    {
        return $this->vendors;
    }

    public function addVendor(Vendor $vendor): self
    {
        if (!$this->vendors->contains($vendor)) {
            $this->vendors[] = $vendor;
            $vendor->addService($this);
        }

        return $this;
    }

    public function removeVendor(Vendor $vendor): self
    {
        if ($this->vendors->contains($vendor)) {
            $this->vendors->removeElement($vendor);
            $vendor->removeService($this);
        }

        return $this;
    }

    public function getPhoto(): ?Image
    {
        return $this->photo;
    }

    public function setPhoto(?Image $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
