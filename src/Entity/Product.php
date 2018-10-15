<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, max = 255)
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 1, max = 255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     * @Assert\Length(max = 1500)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     */
    private $tax = 20;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min = 1, max = 50)
     */
    private $units = 'pièces';

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateUpdate;
    
    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\Type("float")
     */
    private $maxDiscount;

    public function __construct(){
        $this->setDateCreate(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setDateUpdate(new \Datetime());
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }

    public function setUnits(string $units): self
    {
        $this->units = $units;

        return $this;
    }

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMaxDiscount(): ?float
    {
        return $this->maxDiscount;
    }

    public function setMaxDiscount(?float $maxDiscount): self
    {
        $this->maxDiscount = $maxDiscount;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->dateUpdate;
    }

    public function setDateUpdate(\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }
}
