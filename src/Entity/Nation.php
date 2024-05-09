<?php

namespace App\Entity;

use App\Repository\NationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NationRepository::class)]
class Nation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Medal>
     */
    #[ORM\OneToMany(targetEntity: Medal::class, mappedBy: 'nation')]
    private Collection $medals;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->medals = new ArrayCollection();
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

    /**
     * @return Collection<int, Medal>
     */
    public function getMedals(): Collection
    {
        return $this->medals;
    }

    public function addMedal(Medal $medal): static
    {
        if (!$this->medals->contains($medal)) {
            $this->medals->add($medal);
            $medal->setNation($this);
        }

        return $this;
    }

    public function removeMedal(Medal $medal): static
    {
        if ($this->medals->removeElement($medal)) {
            // set the owning side to null (unless already changed)
            if ($medal->getNation() === $this) {
                $medal->setNation(null);
            }
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function countGoldMedals(): int
    {
        return $this->countMedals(Medal::COLOR_OR);
    }

    public function countSilverMedals(): int
    {
        return $this->countMedals(Medal::COLOR_ARGENT);
    }

    public function countBronzeMedals(): int
    {
        return $this->countMedals(Medal::COLOR_BRONZE);
    }

    public function countMedals(string $color): int
    {
        $count = 0;
        foreach ($this->medals as $medal) {
            if ($medal->getColor() === $color) {
                $count++;
            }
        }

        return $count;
    }
}
