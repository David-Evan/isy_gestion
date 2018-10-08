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

    /**
     * Special method to get data from Event Type. It should be extract of this file in future version. 
     */
    public function getUITitle()
    {
        $titles = [
                    self::TYPE_QUOTATION_ADD => 'Devis ajouté',
                    self::TYPE_QUOTATION_ACCEPT => 'Devis accepté',
                    self::TYPE_CUSTOMER_ADD => 'Fiche client créée',
                    self::TYPE_COMMENT_ADD => 'Information ajoutée',
                ];

        return $titles[$this->name];
    }

    public function getUIButton($href)
    {
        $buttons = [
            self::TYPE_QUOTATION_ADD => '<p class="padding-top-10"><a href="'.$href.'" class="btn btn-info pull-right">Afficher le devis</a></p>',
            self::TYPE_QUOTATION_ACCEPT => '<p class="padding-top-10"><a href="'.$href.'" class="btn btn-success pull-right">Afficher la facture</a></p>',
        ];
        
        return array_key_exists($this->name, $buttons) ? $buttons[$this->name] : null; 
    }

    public function getUISubtitle()
    {
        $subtitles = [
            self::TYPE_CUSTOMER_ADD => '<p><strong>Félicitation</strong>, la fiche client vient d\'être ajoutée.</p><p> Faites lui parvenir vos premiers devis !</p>',
        ];
        
        return array_key_exists($this->name, $subtitles) ? $subtitles[$this->name] : null; 
    }

    public function canBeRemove(){
        $canBeRemoves = [
            self::TYPE_QUOTATION_ADD => false,
            self::TYPE_QUOTATION_ACCEPT => false,
            self::TYPE_CUSTOMER_ADD => false,
            self::TYPE_COMMENT_ADD => true,
        ];
        return $canBeRemoves[$this->name];
    }
}
