<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldTypeRepository")
 */
class FieldType
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
    private $name;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $symbol;

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocking;

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

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function __toString()
    {
        return $this->name . " ( ".$this->symbol." )";
    }

    public function getBlocking(): ?bool
    {
        return $this->blocking;
    }

    public function setBlocking(bool $blocking): self
    {
        $this->blocking = $blocking;

        return $this;
    }
}
