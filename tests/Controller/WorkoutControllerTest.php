<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Workout;
use Doctrine\ORM\EntityManagerInterface;

class WorkoutControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    private function logInAsUser(): void
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);
        $this->client->loginUser($user);
    }

    public function testCreateWorkoutPageLoads(): void
    {
        $this->logInAsUser();

        $this->client->request('GET', '/workouts/add');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testShowWorkoutPage(): void
    {
        $this->logInAsUser();

        $workout = $this->entityManager->getRepository(Workout::class)->findOneBy([]);

        $this->client->request('GET', '/workouts/' . $workout->getId());

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Entrainement');
    }

    public function testFavoriteWorkout(): void
    {
        $this->logInAsUser();

        $workout = $this->entityManager->getRepository(Workout::class)->findOneBy([]);

        $this->client->request(
            'POST',
            '/workouts/' . $workout->getId() . '/favorite',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['favorited' => true])
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertTrue($data['success']);
    }
}
