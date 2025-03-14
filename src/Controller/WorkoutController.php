<?php

namespace App\Controller;

use App\Data\CreateWorkoutDTO;
use App\Data\ExerciseDTO;
use App\Entity\Exercise;
use App\Entity\UserWorkout;
use App\Entity\Workout;
use App\Form\CreateWorkoutType;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkoutController extends AbstractController
{
    #[Route('/workouts', name: 'app_workout')]
    public function index(): Response
    {
        return $this->render('workout/index.html.twig', [
            'controller_name' => 'WorkoutController',
        ]);
    }

    #[Route('/workouts/add', name: 'create_workout')]
    public function createWorkout(Request $request, EntityManagerInterface $entityManager, ExerciseRepository $exerciseRepository, UserRepository $userRepository): Response
    {
        $createWorkoutDTO = new CreateWorkoutDTO();
        $form = $this->createForm(CreateWorkoutType::class, $createWorkoutDTO);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $workout = new Workout();
            $workout->setName($createWorkoutDTO->getName());
            $workout->setCreatedBy($this->getUser());
            foreach ($createWorkoutDTO->getExercises() as $exercise) {
                $workout->addExercise($exercise);
            }
            $entityManager->persist($workout);
            $entityManager->flush();
            return $this->redirectToRoute('create_workout');
        }

        return $this->render('workout/create-workout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/workouts/{id}', name: 'show_workout')]
    public function showWorkout(Workout $workout, ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findWorkoutExercises($workout);
        return $this->render('workout/show-workout.html.twig', [
            'exercises' => $exercises,
            'workout' => $workout,
        ]);
    }
}
