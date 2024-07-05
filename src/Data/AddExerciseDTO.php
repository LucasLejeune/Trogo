<?php

namespace App\Data;

use App\Entity\BodyZone;
use App\Entity\Difficulty;
use App\Entity\Equipment;
use App\Entity\ExerciseType;
use App\Entity\Muscle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpParser\Node\Scalar\String_;

class AddExerciseDTO
{
    /**
     * @var Collection<int, Muscle>
     */
    private Collection $muscles;
    /**
     * @var Collection<int, Equipment>
     */
    private Collection $equipments;

    /**
     * @var Collection<int, BodyZone>
     */
    private Collection $bodyZones;

    private Difficulty $difficulty;
    private string $name;

    private ExerciseType $exerciseType;

    public function __construct(){
        $this->muscles = new ArrayCollection();
        $this->equipments = new ArrayCollection();
        $this->bodyZones = new ArrayCollection();
    }

    public function getMuscles(): Collection
    {
        return $this->muscles;
    }

    public function setMuscles(Collection $muscles): void
    {
        $this->muscles = $muscles;
    }

    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function setEquipments(Collection $equipments): void
    {
        $this->equipments = $equipments;
    }

    public function getBodyZones(): Collection
    {
        return $this->bodyZones;
    }

    public function setBodyZones(Collection $bodyZones): void
    {
        $this->bodyZones = $bodyZones;
    }

    public function getDifficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(Difficulty $difficulty): void
    {
        $this->difficulty = $difficulty;
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
}