<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event Type : 
 * 
 *      NAME              ICON              COLOR
 * 'quotation-add'    : paperclip    :     null
 * 'quotation-accept' : check        :     success
 * 'comment-add'      : pencil-alt   :     primary
 * 
 * 
 */

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTypeRepository")
 */
class EventType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\Length(max = 100)
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

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
