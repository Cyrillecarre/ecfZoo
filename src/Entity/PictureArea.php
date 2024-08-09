<?php

namespace App\Entity;

use App\Repository\PictureAreaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureAreaRepository::class)]
class PictureArea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fileName = null;

    #[ORM\ManyToOne(inversedBy: 'pictureAreas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Area $Area = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

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
}
