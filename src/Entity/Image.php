<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="logos")
     */
    private $logo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="pictures")
     */
    private $pictures;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getLogo(): ?Vendor
    {
        return $this->logo;
    }

    public function setLogo(?Vendor $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPictures(): ?Vendor
    {
        return $this->pictures;
    }

    public function setPictures(?Vendor $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }

}
