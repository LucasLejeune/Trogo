<?php

namespace App\Data;

use App\Entity\Difficulty;
use App\Entity\Exercise;
use App\Entity\ExerciseType;

class ExerciseDTO
{
    private string $name;
    private Difficulty $difficulty;
    private ExerciseType $exerciseType;
    private bool $selected = false;

    public function __construct(Exercise $exercise)
    {
        $this->name = $exercise->getName();
        $this->difficulty = $exercise->getDifficulty();
        $this->exerciseType = $exercise->getExerciseType();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getExerciseType(): ExerciseType
    {
        return $this->exerciseType;
    }

    public function setExerciseType(ExerciseType $exerciseType): void
    {
        $this->exerciseType = $exerciseType;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(Difficulty $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

    public function isSelected(): bool
    {
        return $this->selected;
    }

    public function setSelected(bool $selected): void
    {
        $this->selected = $selected;
    }
}