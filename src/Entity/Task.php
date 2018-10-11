<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     * @Assert\Length(min = 3, max = 500)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\Datetime
     */
    private $dateDue;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Datetime
     */
    private $dateCreate;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    public function __construct(){
        $this->dateCreate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDue(): ?\DateTimeInterface
    {
        return $this->dateDue;
    }

    public function setDateDue(\DateTimeInterface $dateDue): self
    {
        $this->dateDue = $dateDue;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
