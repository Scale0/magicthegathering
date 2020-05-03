<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FieldElementRepository")
 */
class FieldElement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FieldType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fieldType;

    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldType(): ?FieldType
    {
        return $this->fieldType;
    }

    public function setFieldType(?FieldType $fieldType): self
    {
        $this->fieldType = $fieldType;

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }
}
