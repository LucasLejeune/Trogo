<?php

namespace App\Repository;

use App\Entity\Exercise;
use App\Entity\Muscle;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Muscle>
 */
class MuscleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Muscle::class);
    }

    /**
     * @param Workout $workout
     * @return Muscle[]
     */
    public function findAllByWorkout(Workout $workout): array
    {
        $queryBuilder = $this->createQueryBuilder('muscle');

        return $queryBuilder
            ->innerJoin('muscle.exercises', 'exercise')
            ->innerJoin('exercise.workouts', 'workout')
            ->andWhere($queryBuilder->expr()->eq('workout', ':workout'))
            ->setParameter('workout', $workout)
            ->distinct()
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Exercise $exercise
     * @return Muscle[]
     */
    public function findAllByExercise(Exercise $exercise): array
    {
        $queryBuilder = $this->createQueryBuilder('muscle');

        return $queryBuilder
            ->innerJoin('muscle.exercises', 'exercise')
            ->andWhere($queryBuilder->expr()->eq('exercise', ':exercise'))
            ->setParameter('exercise', $exercise)
            ->distinct()
            ->getQuery()
            ->getResult();
    }
}
