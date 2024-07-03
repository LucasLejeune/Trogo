<?php

namespace App\Form;

use App\Data\CreateWorkoutDTO;
use App\Entity\Exercise;
use App\Entity\User;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateWorkoutType extends AbstractType
{
    public function __construct(ExerciseRepository $exerciseRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
                'choice_label' => 'name',
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
