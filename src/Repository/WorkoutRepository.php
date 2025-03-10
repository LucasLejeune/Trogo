<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\User;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 */
class WorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workout::class);
    }

    public function findUserFavorites(User $user)
    {
        $queryBuilder = $this->createQueryBuilder('workout');

        return $queryBuilder
            ->innerJoin('workout.users', 'users')
            ->andWhere($queryBuilder->expr()->eq('users', ':user'))
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Collection<Equipment> $equipments
     * @return Workout[]
     */
    public function findByEquipment(Collection $equipments): array
    {
        $queryBuilder = $this->createQueryBuilder('workout');

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Workout[] Returns an array of Workout objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Workout
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
