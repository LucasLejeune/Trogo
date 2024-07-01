<?php

namespace App\Entity;

use App\Repository\BodyZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BodyZoneRepository::class)]
class BodyZone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'bodyZones')]
    private Collection $exercises;

    /**
     * @var Collection<int, Muscle>
     */
    #[ORM\OneToMany(targetEntity: Muscle::class, mappedBy: 'bodyZone')]
    private Collection $muscles;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
        $this->muscles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->addBodyZone($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        if ($this->exercises->removeElement($exercise)) {
            $exercise->removeBodyZone($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Muscle>
     */
    public function getMuscles(): Collection
    {
        return $this->muscles;
    }

    public function addMuscle(Muscle $muscle): static
    {
        if (!$this->muscles->contains($muscle)) {
            $this->muscles->add($muscle);
            $muscle->setBodyZone($this);
        }

        return $this;
    }

    public function removeMuscle(Muscle $muscle): static
    {
        if ($this->muscles->removeElement($muscle)) {
            // set the owning side to null (unless already changed)
            if ($muscle->getBodyZone() === $this) {
                $muscle->setBodyZone(null);
            }
        }

        return $this;
    }
}
