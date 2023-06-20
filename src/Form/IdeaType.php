<?php

namespace App\Form;

use App\Entity\Idea;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IdeaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Mon idée en quelques mots'
            ])
            ->add('perimeter', ChoiceType::class, [
                'label' => 'A qui est destinée mon idée?',
                'choices' => [
                    'A tout le monde' => 'Global',
                    'A mon agence' => 'Agence',
                    'A mon service' => 'Service',
                ],
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Expliquer mon idée'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Idea::class,
        ]);
    }
}
