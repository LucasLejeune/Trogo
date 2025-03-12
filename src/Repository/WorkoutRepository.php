<?php

namespace App\Repository;

use App\Entity\Equipment;
use App\Entity\User;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\IsNull;

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

    public function getWorkoutIdsByUserEquipment(int $userId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql =
            "SELECT DISTINCT w.id
        FROM workout w
        JOIN workout_exercise we ON w.id = we.workout_id
        JOIN exercise e ON we.exercise_id = e.id
        JOIN exercise_equipment ee ON e.id = ee.exercise_id
        JOIN user_equipment ue ON ee.equipment_id = ue.equipment_id
        WHERE ue.user_id = :userId
        GROUP BY w.id, w.name
        HAVING COUNT(DISTINCT ee.equipment_id) = (
            SELECT COUNT(DISTINCT ee2.equipment_id)
            FROM workout_exercise we2
            JOIN exercise e2 ON we2.exercise_id = e2.id
            JOIN exercise_equipment ee2 ON e2.id = ee2.exercise_id
            WHERE we2.workout_id = w.id
        )";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);
        return $resultSet->fetchAllAssociative();
    }

    public function getWorkoutsByUserEquipment(int $userId): array
    {
        $workoutIds = $this->getWorkoutIdsByUserEquipment($userId);
        $queryBuilder = $this->createQueryBuilder('workout');

        return $queryBuilder
            ->addSelect('exercise')
            ->innerJoin('workout.exercises', 'exercise')
            ->andWhere($queryBuilder->expr()->in('workout.id', ':workoutIds'))
            ->setParameter('workoutIds', $workoutIds)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithoutEquipment(): array
    {
        $queryBuilder = $this->createQueryBuilder('workout');

        return $queryBuilder
            ->leftJoin('workout.exercises', 'exercise')
            ->leftJoin('exercise.equipments', 'equipment')
            ->having('COUNT(equipment.id) = 0')
            ->groupBy('workout.id')
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
