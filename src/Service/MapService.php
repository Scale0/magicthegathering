<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\FieldElementRepository;
use App\Repository\FieldTypeRepository;

final class MapService
{
    private $fieldElementRepository;
    private $fieldTypeRepository;
    public function __construct(FieldElementRepository $fieldElement, FieldTypeRepository $fieldTypeRepository)
    {
        $this->fieldElementRepository = $fieldElement;
        $this->fieldTypeRepository = $fieldTypeRepository;
    }

    public function generate()
    {
        $elements = $this->fieldElementRepository->findAll();
        $field = [];
        foreach($elements as $element) {
            $field[$element->getX()][$element->getY()] = ['id' => $element->getId(), 'symbol' => $element->getFieldType()->getSymbol()];
        }
        return $field;
    }

    /**
     * @return \App\Entity\FieldType
     */
    public function getEmptyTile() {
        return $this->fieldTypeRepository->findOneBy(['name' => 'grass']);
    }
}
