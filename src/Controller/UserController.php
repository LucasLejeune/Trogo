<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\User;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users/{id}', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users/{id}/equipments', name: 'get_user_equipment')]
    public function addEquipment(User $user, EquipmentRepository $equipmentRepository): Response
    {
        $userEquipments = $user->getEquipments();

        $allEquipments = new ArrayCollection($equipmentRepository->findAll());
        $equipments = $allEquipments->filter(fn(Equipment $equipment) => !$userEquipments->contains($equipment));
        return $this->render('user/get-equipment.html.twig', [
            'userEquipments' => $userEquipments,
            'equipments' => $equipments,
            'user' => $user,
        ]);
    }

    #[Route('/users/{user}/equipments/{equipment}/add', name: 'add_user_equipment')]
    public function addUserEquipment(User $user, Equipment $equipment, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user->addEquipment($equipment);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('get_user_equipment', ['id' => $user->getId()]);
    }

    #[Route('/users/{user}/equipments/{equipment}/delete', name: 'delete_user_equipment')]
    public function deleteUserEquipment(User $user, Equipment $equipment, EntityManagerInterface $entityManager): RedirectResponse
    {
        $user->removeEquipment($equipment);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('get_user_equipment', ['id' => $user->getId()]);
    }
}
