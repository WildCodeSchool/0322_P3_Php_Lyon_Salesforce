<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'label' => 'Profile picture',
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
            ->add('service', TextType::class, [
                'label' => 'Service'
            ])
            ->add('office', TextType::class, [
                'label' => 'Agence'
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
