<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class CustomerComment {

    /**
     * @Assert\Length(min = 3, max = 1500)
     */
    private $comment;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}