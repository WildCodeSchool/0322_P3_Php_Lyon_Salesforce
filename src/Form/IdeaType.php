<?php

namespace App\Form;

use App\Entity\Idea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Votre idée en quelques mots:'
            ])
            ->add('perimeter', ChoiceType::class, [
                'label' => 'Séléctionnez le service concerné',
                'choices' => [
                    'National' => [
                        'Service Comptabilité France' => 'Service Comptabilité France',
                        'Service RH France' => 'Service RH France',
                        'Service Informatique France' => 'Service Informatique France',
                        'Service Technique France' => 'Service Technique France',
                    ],
                    'Régions' => [
                        'Service Comptabilité Nord' => 'Service Comptabilité Nord',
                        'Service Comptabilité Sud' => 'Service Comptabilité Sud',
                        'Service Comptabilité Est' => 'Service Comptabilité Est',
                        'Service Comptabilité Ouest' => 'Service Comptabilité Ouest',
                        'Service RH Nord' => 'Service RH Nord',
                        'Service RH Sud' => 'Service RH Sud',
                        'Service RH Est' => 'Service RH Est',
                        'Service RH Ouest' => 'Service RH Ouest',
                        'Service Informatique Nord' => 'Service Informatique Nord',
                        'Service Informatique Sud' => 'Service Informatique Sud',
                        'Service Informatique Est' => 'Service Informatique Est',
                        'Service Informatique Ouest' => 'Service Informatique Ouest',
                        'Service Technique Nord' => 'Service Technique Nord',
                        'Service Technique Sud' => 'Service Technique Sud',
                        'Service Technique Est' => 'Service Technique Est',
                        'Service Technique Ouest' => 'Service Technique Ouest',
                    ],
                    'Agence de Paris' => [
                        'Service Comptabilité Paris' => 'Service Comptabilité Paris',
                        'Service RH Paris' => 'Service RH Paris',
                        'Service Informatique Paris' => 'Service Informatique Paris',
                        'Service Technique Paris' => 'Service Technique Paris',
                    ],
                    'Agence de Lyon' => [
                        'Service Comptabilité Lyon' => 'Service Comptabilité Lyon',
                        'Service RH Lyon' => 'Service RH Lyon',
                        'Service Informatique Lyon' => 'Service Informatique Lyon',
                        'Service Technique Lyon' => 'Service Technique Lyon',
                    ],
                    'Agence de Corse' => [
                        'Service Comptabilité Corse' => 'Service Comptabilité Corse',
                        'Service RH Corse' => 'Service RH Corse',
                        'Service Informatique Corse' => 'Service Informatique Corse',
                        'Service Technique Corse' => 'Service Technique Corse',
                    ],
                    'Agence de Brest' => [
                        'Service Comptabilité Brest' => 'Service Comptabilité Brest',
                        'Service RH Brest' => 'Service RH Brest',
                        'Service Informatique Brest' => 'Service Informatique Brest',
                        'Service Technique Brest' => 'Service Technique Brest',
                    ],

                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}
