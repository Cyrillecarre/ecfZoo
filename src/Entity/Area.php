<?php

namespace App\Entity;

use App\Repository\AreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AreaRepository::class)]
class Area
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    /**
     * @var Collection<int, PictureArea>
     */
    #[ORM\OneToMany(targetEntity: PictureArea::class, mappedBy: 'Area', orphanRemoval: true)]
    private Collection $pictureAreas;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'Area')]
    private Collection $animals;

    public function __construct()
    {
        $this->pictureAreas = new ArrayCollection();
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, PictureArea>
     */
    public function getPictureAreas(): Collection
    {
        return $this->pictureAreas;
    }

    public function addPictureArea(PictureArea $pictureArea): static
    {
        if (!$this->pictureAreas->contains($pictureArea)) {
            $this->pictureAreas->add($pictureArea);
            $pictureArea->setArea($this);
        }

        return $this;
    }

    public function removePictureArea(PictureArea $pictureArea): static
    {
        if ($this->pictureAreas->removeElement($pictureArea)) {
            // set the owning side to null (unless already changed)
            if ($pictureArea->getArea() === $this) {
                $pictureArea->setArea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setArea($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getArea() === $this) {
                $animal->setArea(null);
            }
        }

        return $this;
    }
}
