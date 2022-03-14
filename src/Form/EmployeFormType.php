<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Quel est votre prénom ?'
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Quel est votre nom ?'
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date de naissance'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name'
            ])
            ->add('salaire', TextType::class, [
                'label' => 'Salaire',
                'attr' => [
                    'placeholder' => '€'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter' ,
//                'validate' => false,
                'attr' => [
                    'class' => 'd-block col-3 mx-auto btn btn-warning'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
