<?php

namespace App\Form;

use App\Entity\Office;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un fichier PNG, JPEG ou GIF',
                    ])
                ],
            ])
            ->add('department', ChoiceType::class, [
                'label' => 'Service',
                'choices' => [
                    'Ressources Humaines' => 'Ressources Humaines',
                    'Informatique' => 'Informatique',
                    'Comptabilité' => 'Comptabilité',
                    'Marketing' => 'Marketing',
                    'Communication' => 'Communication',
                    'Commercial' => 'Commercial',
                ]
            ])
            ->add('workplace', EntityType::class, [
                'class' => Office::class,
                'label' => 'Agence',
                'choice_label' => 'location',
            ])
            ->add('position', TextType::class, [
                'label' => 'Poste'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
