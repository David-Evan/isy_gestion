<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTypeRepository")
 */
class EventType
{
    const  TYPE_QUOTATION_ADD = 'quotation-add',
           TYPE_QUOTATION_ACCEPT = 'quotation-accept',
           TYPE_CUSTOMER_ADD = 'customer-add',
           TYPE_COMMENT_ADD = 'comment-add'
        ;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Choice(choices={EventType::TYPE_QUOTATION_ADD,EventType::TYPE_QUOTATION_ACCEPT,EventType::TYPE_CUSTOMER_ADD,EventType::TYPE_COMMENT_ADD})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=70)
     * @Assert\Length(max = 70)
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     * @Assert\Length(max = 70)
     */
    private $color;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
