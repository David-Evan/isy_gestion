<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Customer
{

    const 
        TYPE_INDIVIDUAL = 'individual',
        TYPE_PROFESSIONNAL = 'professionnal',
        TYPE_PUBLIC = 'public_company';

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
     * @Assert\Length(min = 3, max = 255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(choices={Customer::TYPE_INDIVIDUAL, Customer::TYPE_PROFESSIONNAL, Customer::TYPE_PUBLIC})
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type("bool")
     */
    private $isProspectiveCustomer = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureURL;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIsProspectiveCustomer(): ?bool
    {
        return $this->isProspectiveCustomer;
    }

    public function setIsProspectiveCustomer(bool $isProspectiveCustomer): self
    {
        $this->isProspectiveCustomer = $isProspectiveCustomer;

        return $this;
    }

    public function getPictureURL(): ?string
    {
        return $this->pictureURL;
    }

    public function setPictureURL(?string $pictureURL): self
    {
        $this->pictureURL = $pictureURL;

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

    public function getCustomer(): ?self
    {
        return $this->customer;
    }

    public function setCustomer(?self $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
