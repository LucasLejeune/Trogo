<?php

namespace App\Controller;

use App\Data\AddExerciseDTO;
use App\Entity\Exercise;
use App\Form\AddExerciseType;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    #[Route('/exercises/{id}', name: 'show_exercise', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function ShowExercise(Exercise $exercise, ExerciseRepository $exerciseRepository): Response
    {
        $exerciseRepository->findOneBy(['id' => $exercise->getId()]);

        return $this->render('exercise/show-exercise.html.twig', [
            'exercise' => $exercise,
        ]);
    }

    #[Route('/exercises/add', name: 'add_exercise')]
    public function addExercise(Request $request, EntityManagerInterface $entityManager): Response
    {
        $addExerciseDTO = new AddExerciseDTO();
        $form = $this->createForm(AddExerciseType::class, $addExerciseDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $exercise = new Exercise();
            $exercise->setName($addExerciseDTO->getName());
            $exercise->setExerciseType($addExerciseDTO->getExerciseType());
            $exercise->setDifficulty($addExerciseDTO->getDifficulty());
            foreach ($addExerciseDTO->getEquipments() as $equipment) {
                $exercise->addEquipment($equipment);
            }
            foreach ($addExerciseDTO->getMuscles() as $muscle) {
                $exercise->addMuscle($muscle);
            }
            foreach ($addExerciseDTO->getBodyZones() as $bodyZone) {
                $exercise->addBodyZone($bodyZone);
            }
            $entityManager->persist($exercise);
            $entityManager->flush();
            $this->addFlash('success', 'Exercice ajouté avec succès');
            return $this->redirectToRoute('add_exercise');
        }

        return $this->render('exercise/add_exercise.html.twig', [
            'form' => $form,
        ]);
    }


}
