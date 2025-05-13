<?php

namespace App\Controller;

use App\Data\CreateWorkoutDTO;
use App\Data\ExerciseDTO;
use App\Entity\Exercise;
use App\Entity\UserWorkout;
use App\Entity\Workout;
use App\Form\CreateWorkoutType;
use App\Repository\EquipmentRepository;
use App\Repository\ExerciseRepository;
use App\Repository\MuscleRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function showWorkout(Workout $workout, ExerciseRepository $exerciseRepository, MuscleRepository $muscleRepository, EquipmentRepository $equipmentRepository): Response
    {
        $user = $this->getUser();
        $muscles = $muscleRepository->findAllByWorkout($workout);
        $exercises = $exerciseRepository->findWorkoutExercises($workout);
        $equipments = $equipmentRepository->findAllByWorkout($workout);

        return $this->render('workout/show-workout.html.twig', [
            'exercises' => $exercises,
            'workout' => $workout,
            'muscles' => $muscles,
            'equipments' => $equipments,
            'isFavorite' => $workout->getUsers()->contains($user),
        ]);
    }

    #[Route('/workouts/{id}/favorite', name: 'manage_workout_favorite')]
    public function manageWorkoutFavoriteState(Workout $workout, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $isFavorited = $data['favorited'] ?? null;

        $user = $this->getUser();
        $workoutUsers = $workout->getUsers();
        $isEdit = false;

        if ($isFavorited && !$workoutUsers->contains($user)) {
            $workout->addUser($user);
            $isEdit = true;
        } elseif (!$isFavorited && $workoutUsers->contains($user)) {
            $workout->removeUser($user);
            $isEdit = true;
        }
        if ($isEdit) {
            $em->persist($workout);
            $em->flush();
        }

        return new JsonResponse(['success' => true, 'favorited' => !$isFavorited, 'edit' => $isEdit]);
    }
}
