<?php

namespace App\Entity;

use App\Repository\MedalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedalRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Medal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    #[Assert\NotBlank(message: 'Veuillez choisir la couleur de la médaille')]
    private ?string $color = null;

    #[ORM\Column]
    private ?int $point = null;

    #[ORM\ManyToOne(inversedBy: 'medals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Veuillez choisir le sport')]
    private ?Sport $sport = null;

    #[ORM\ManyToOne(inversedBy: 'medals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nation $nation = null;

    public const COLOR_OR       = 'or';
    public const COLOR_ARGENT   = 'argent';
    public const COLOR_BRONZE   = 'bronze';

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->setPoint(1);

        if ($this->getColor() == Medal::COLOR_OR) {
            $this->setPoint(3);
        } elseif ($this->getColor() == Medal::COLOR_ARGENT) {
            $this->setPoint(2);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function getNation(): ?Nation
    {
        return $this->nation;
    }

    public function setNation(?Nation $nation): static
    {
        $this->nation = $nation;

        return $this;
    }
}
