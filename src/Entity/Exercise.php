<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Workout>
     */
    #[ORM\ManyToMany(targetEntity: Workout::class, mappedBy: 'exercises')]
    private Collection $workouts;

    /**
     * @var Collection<int, Equipment>
     */
    #[ORM\ManyToMany(targetEntity: Equipment::class, inversedBy: 'exercises')]
    private Collection $equipments;

    /**
     * @var Collection<int, BodyZone>
     */
    #[ORM\ManyToMany(targetEntity: BodyZone::class, inversedBy: 'exercises')]
    private Collection $bodyZones;

    /**
     * @var Collection<int, Muscle>
     */
    #[ORM\ManyToMany(targetEntity: Muscle::class, inversedBy: 'exercises')]
    private Collection $muscles;

    public function __construct()
    {
        $this->workouts = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->bodyZones = new ArrayCollection();
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
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): static
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts->add($workout);
            $workout->addExercise($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): static
    {
        if ($this->workouts->removeElement($workout)) {
            $workout->removeExercise($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getEquipment(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): static
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments->add($equipment);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): static
    {
        $this->equipments->removeElement($equipment);

        return $this;
    }

    /**
     * @return Collection<int, BodyZone>
     */
    public function getBodyZone(): Collection
    {
        return $this->bodyZones;
    }

    public function addBodyZone(BodyZone $bodyZone): static
    {
        if (!$this->bodyZones->contains($bodyZone)) {
            $this->bodyZones->add($bodyZone);
        }

        return $this;
    }

    public function removeBodyZone(BodyZone $bodyZone): static
    {
        $this->bodyZones->removeElement($bodyZone);

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
        }

        return $this;
    }

    public function removeMuscle(Muscle $muscle): static
    {
        $this->muscles->removeElement($muscle);

        return $this;
    }
}
