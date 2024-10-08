<?php

namespace App\Entity;

use App\Repository\RecommandationVeterinaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecommandationVeterinaryRepository::class)]
class RecommandationVeterinary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $medicine = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recommandation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $report = null;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'recommandationVeterinary', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $Animal = null;

    #[ORM\ManyToMany(targetEntity: Food::class, inversedBy: 'recommandationVeterinaries', cascade: ['persist'])]
    private Collection $foods;

    #[ORM\OneToOne(mappedBy: 'recommandationVeterinary', cascade: ['persist', 'remove'])]
    private ?Monitoring $monitoring = null;

    public function __construct()
    {
        $this->foods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicine(): ?string
    {
        return $this->medicine;
    }

    public function setMedicine(?string $medicine): static
    {
        $this->medicine = $medicine;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getRecommandation(): ?string
    {
        return $this->recommandation;
    }

    public function setRecommandation(?string $recommandation): static
    {
        $this->recommandation = $recommandation;

        return $this;
    }

    public function getReport(): ?string
    {
        return $this->report;
    }

    public function setReport(?string $report): static
    {
        $this->report = $report;

        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->Animal;
    }

    public function setAnimal(?Animal $Animal): static
    {
        $this->Animal = $Animal;

        return $this;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getFoods(): Collection
    {
        return $this->foods;
    }

    public function addFood(Food $food): static
    {
        if (!$this->foods->contains($food)) {
            $this->foods->add($food);
        }

        return $this;
    }

    public function removeFood(Food $food): static
    {
        $this->foods->removeElement($food);

        return $this;
    }

    public function getMonitoring(): ?Monitoring
    {
        return $this->monitoring;
    }

    public function setMonitoring(?Monitoring $monitoring): static
    {
        if ($monitoring !== null && $monitoring->getRecommandationVeterinary() !== $this) {
            $monitoring->setRecommandationVeterinary($this);
        }

        $this->monitoring = $monitoring;

        return $this;
    }
}