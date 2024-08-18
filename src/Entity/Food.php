<?php
namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    /**
     * @var Collection<int, RecommandationVeterinary>
     */
    #[ORM\ManyToMany(targetEntity: RecommandationVeterinary::class, mappedBy: 'foods')]
    private Collection $recommandationVeterinaries;

    public function __construct()
    {
        $this->recommandationVeterinaries = new ArrayCollection();
    }

    // Getters and setters...

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, RecommandationVeterinary>
     */
    public function getRecommandationVeterinaries(): Collection
    {
        return $this->recommandationVeterinaries;
    }

    public function addRecommandationVeterinary(RecommandationVeterinary $recommandationVeterinary): self
    {
        if (!$this->recommandationVeterinaries->contains($recommandationVeterinary)) {
            $this->recommandationVeterinaries->add($recommandationVeterinary);
            $recommandationVeterinary->addFood($this);
        }

        return $this;
    }

    public function removeRecommandationVeterinary(RecommandationVeterinary $recommandationVeterinary): self
    {
        if ($this->recommandationVeterinaries->removeElement($recommandationVeterinary)) {
            $recommandationVeterinary->removeFood($this);
        }

        return $this;
    }
}
