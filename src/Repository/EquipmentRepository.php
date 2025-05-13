<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipment>
 */
class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    public function findAllByWorkout(Workout $workout): array
    {
        $queryBuilder = $this->createQueryBuilder('equipment');
        return $queryBuilder
            ->innerJoin('equipment.exercises', 'exercise')
            ->innerJoin('exercise.workouts', 'workout')
            ->andWhere($queryBuilder->expr()->eq('workout', ':workout'))
            ->setParameter('workout', $workout)
            ->getQuery()
            ->getResult();
    }
}
