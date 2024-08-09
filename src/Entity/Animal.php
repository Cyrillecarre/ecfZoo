<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $race = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Area $Area = null;

    /**
     * @var Collection<int, PictureAnimal>
     */
    #[ORM\OneToMany(targetEntity: PictureAnimal::class, mappedBy: 'Animal', orphanRemoval: true)]
    private Collection $pictureAnimals;

    #[ORM\OneToOne(mappedBy: 'Animal', cascade: ['persist', 'remove'])]
    private ?RecommandationVeterinary $recommandationVeterinary = null;

    public function __construct()
    {
        $this->pictureAnimals = new ArrayCollection();
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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->Area;
    }

    public function setArea(?Area $Area): static
    {
        $this->Area = $Area;

        return $this;
    }

    /**
     * @return Collection<int, PictureAnimal>
     */
    public function getPictureAnimals(): Collection
    {
        return $this->pictureAnimals;
    }

    public function addPictureAnimal(PictureAnimal $pictureAnimal): static
    {
        if (!$this->pictureAnimals->contains($pictureAnimal)) {
            $this->pictureAnimals->add($pictureAnimal);
            $pictureAnimal->setAnimal($this);
        }

        return $this;
    }

    public function removePictureAnimal(PictureAnimal $pictureAnimal): static
    {
        if ($this->pictureAnimals->removeElement($pictureAnimal)) {
            // set the owning side to null (unless already changed)
            if ($pictureAnimal->getAnimal() === $this) {
                $pictureAnimal->setAnimal(null);
            }
        }

        return $this;
    }

    public function getRecommandationVeterinary(): ?RecommandationVeterinary
    {
        return $this->recommandationVeterinary;
    }

    public function setRecommandationVeterinary(RecommandationVeterinary $recommandationVeterinary): static
    {
        // set the owning side of the relation if necessary
        if ($recommandationVeterinary->getAnimal() !== $this) {
            $recommandationVeterinary->setAnimal($this);
        }

        $this->recommandationVeterinary = $recommandationVeterinary;

        return $this;
    }
}
