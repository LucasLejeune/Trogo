<?php

namespace App\Form;

use App\Data\CreateWorkoutDTO;
use App\Entity\Equipment;
use App\Entity\Exercise;
use App\Entity\User;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateWorkoutType extends AbstractType
{
    private Security $security;
    private UserRepository $userRepository;

    public function __construct(Security $security, UserRepository $userRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->userRepository->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()]);
        $userEquipments = $user->getEquipments();

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('exercises', EntityType::class, [
                'class' => Exercise::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($userEquipments) {
                    return $er->createQueryBuilder('exercise')
                        ->leftJoin('exercise.equipments', 'equipment')
                        ->orWhere('equipment IS NULL')
                        ->orWhere('equipment IN (:userEquipments)')
                        ->setParameter('userEquipments', $userEquipments->map(fn(Equipment $equipment) => $equipment->getId()));
                },
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateWorkoutDTO::class,
        ]);
    }
}
