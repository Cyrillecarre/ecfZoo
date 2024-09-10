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
    private ?Area $area = null;

    #[ORM\OneToMany(mappedBy: 'Animal', targetEntity: PictureAnimal::class, orphanRemoval: true)]
    private Collection $pictureAnimals;

    #[ORM\OneToMany(mappedBy: 'Animal', targetEntity: RecommandationVeterinary::class)]
    private Collection $recommandationVeterinary;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: Monitoring::class)]
    private Collection $monitorings;

    public function __construct()
    {
        $this->pictureAnimals = new ArrayCollection();
        $this->recommandationVeterinary = new ArrayCollection();
        $this->monitorings = new ArrayCollection();
    }

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

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;
        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return Collection<int, PictureAnimal>
     */
    public function getPictureAnimals(): Collection
    {
        return $this->pictureAnimals;
    }

    public function addPictureAnimal(PictureAnimal $pictureAnimal): self
    {
        if (!$this->pictureAnimals->contains($pictureAnimal)) {
            $this->pictureAnimals[] = $pictureAnimal;
            $pictureAnimal->setAnimal($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RecommandationVeterinary>
     */
    public function getRecommandationVeterinary(): Collection
    {
        return $this->recommandationVeterinary;
    }

    public function addRecommandationVeterinary(RecommandationVeterinary $recommandationVeterinary): self
    {
        if (!$this->recommandationVeterinary->contains($recommandationVeterinary)) {
            $this->recommandationVeterinary[] = $recommandationVeterinary;
            $recommandationVeterinary->setAnimal($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Monitoring>
     */
    public function getMonitorings(): Collection
    {
        return $this->monitorings;
    }

    public function addMonitoring(Monitoring $monitoring): self
    {
        if (!$this->monitorings->contains($monitoring)) {
            $this->monitorings[] = $monitoring;
            $monitoring->setAnimal($this);
        }

        return $this;
    }
}