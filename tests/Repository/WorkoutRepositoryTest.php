<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WorkoutRepositoryTest extends KernelTestCase
{
    private WorkoutRepository $workoutRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->workoutRepository = static::getContainer()->get(WorkoutRepository::class);
    }

    public function testFindUserFavorites(): void
    {
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['id' => 1]);

        $favorites = $this->workoutRepository->findUserFavorites($user);

        $this->assertIsArray($favorites);
        foreach ($favorites as $workout) {
            $this->assertInstanceOf(Workout::class, $workout);
        }
    }

    public function testGetWorkoutIdsByUserEquipment(): void
    {
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['id' => 1]);
        $result = $this->workoutRepository->getWorkoutIdsByUserEquipment($user->getId());

        $this->assertIsArray($result);
        foreach ($result as $row) {
            $this->assertArrayHasKey('id', $row);
        }
    }

    public function testGetWorkoutsByUserEquipment(): void
    {
        $user = static::getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['id' => 1]);
        $result = $this->workoutRepository->getWorkoutsByUserEquipment($user->getId());

        $this->assertIsArray($result);
        foreach ($result as $workout) {
            $this->assertInstanceOf(Workout::class, $workout);
        }
    }

    public function testFindAllWithoutEquipment(): void
    {
        $result = $this->workoutRepository->findAllWithoutEquipment();

        $this->assertIsArray($result);
        foreach ($result as $workout) {
            $this->assertInstanceOf(Workout::class, $workout);
        }
    }
}
