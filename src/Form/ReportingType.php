<?php

namespace App\Form;

use App\Entity\Reporting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reportDate')
            ->add('motive', ChoiceType::class, [
                'label' => 'Raison',
                'choices' => [
                    'Inapproprié' => 'Inapproprié',
                    'Spam' => 'Spam',
                    'Violence' => 'Violence',
                    'Contenu à caractère sexuel' => 'Contenu à caractère sexuel',
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reporting::class,
        ]);
    }
}
