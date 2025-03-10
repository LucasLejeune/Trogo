<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
        if ($user instanceof User) {
            $workouts = $workoutRepository->findByEquipment($user->getEquipments());
            dd($workouts);
        }
        return $this->render('home/home.html.twig', [
            'user' => $user,
        ]);
    }
}
