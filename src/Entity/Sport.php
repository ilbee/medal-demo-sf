<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SportRepository::class)]
class Sport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $category = null;

    /**
     * @var Collection<int, Medal>
     */
    #[ORM\OneToMany(targetEntity: Medal::class, mappedBy: 'sport', orphanRemoval: true)]
    private Collection $medals;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

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
            $medal->setSport($this);
        }

        return $this;
    }

    public function removeMedal(Medal $medal): static
    {
        if ($this->medals->removeElement($medal)) {
            // set the owning side to null (unless already changed)
            if ($medal->getSport() === $this) {
                $medal->setSport(null);
            }
        }

        return $this;
    }

    public function getFullName(): string
    {
        if ($this->getCategory()) {
            return sprintf('%s (%s)', $this->getName(), $this->getCategory());
        }

        return $this->getName();
    }
}
