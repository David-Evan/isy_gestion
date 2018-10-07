<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     * @Assert\Length(max = 1500)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $additionalInformation;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EventType", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

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

    public function setDateUpdate(?\DateTimeInterface $dateUpdate): self
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getType(): ?EventType
    {
        return $this->type;
    }

    public function setType(EventType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
