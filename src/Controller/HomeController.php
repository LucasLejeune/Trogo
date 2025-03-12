<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\User;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Common\Collections\ArrayCollection;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_landing')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/home', name: "app_home")]
    public function home(WorkoutRepository $workoutRepository): Response
    {
        $user =  $this->getUser();
        $workouts = new ArrayCollection($workoutRepository->findAllWithoutEquipment());
        if ($user instanceof User) {
            $userWorkouts = $workoutRepository->getWorkoutsByUserEquipment($user->getId());
            foreach ($userWorkouts as $workout) {
                $workouts->add($workout);
            }
        }
        return $this->render('home/home.html.twig', [
            'workouts' => $workouts,
        ]);
    }
}
