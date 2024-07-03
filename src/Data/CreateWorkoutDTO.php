<?php

namespace App\Data;

use App\Entity\Exercise;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CreateWorkoutDTO
{
    private string $name;
    /**
     * @var Collection<int, Exercise>
     */
    private Collection $exercises;

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function setExercises(Collection $exercises): void
    {
        $this->exercises = $exercises;
    }
}