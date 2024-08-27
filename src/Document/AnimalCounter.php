<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class AnimalCounter
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $animalId;

    /**
     * @MongoDB\Field(type="int")
     */
    private $count = 0;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAnimalId(): ?string
    {
        return $this->animalId;
    }

    public function setAnimalId(string $animalId): self
    {
        $this->animalId = $animalId;
        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function incrementCount(): self
    {
        $this->count++;
        return $this;
    }
}