<?php

namespace App\Form;

use App\Data\AddExerciseDTO;
use App\Entity\BodyZone;
use App\Entity\Difficulty;
use App\Entity\Equipment;
use App\Entity\ExerciseType;
use App\Entity\Muscle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddExerciseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('difficulty', EntityType::class, [
                'class' => Difficulty::class,
                'label' => 'Difficulté',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
            ->add('muscles', EntityType::class, [
                'class' => Muscle::class,
                'label' => 'Muscle',
                'expanded' => false,
                'multiple' => true,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
            ->add('equipments', EntityType::class, [
                'class' => Equipment::class,
                'label' => 'Équipement',
                'expanded' => false,
                'multiple' => true,
                'choice_label' => 'name',
                'required' => false,
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
            ->add('bodyZones', EntityType::class, [
                'class' => BodyZone::class,
                'label' => 'Zone du corps',
                'expanded' => false,
                'multiple' => true,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
            ->add('exerciseType', EntityType::class, [
                'class' => ExerciseType::class,
                'label' => "Type d'exercice",
                'expanded' => false,
                'multiple' => false,
                'placeholder' => "Sélectionner un type d'exercice",
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddExerciseDTO::class,
        ]);
    }
}
