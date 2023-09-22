<?php

namespace App\Form;

use App\Entity\Assurance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssuranceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numOrdre')
            ->add('numPolice')
            ->add('dateEffet')
            ->add('mois')
            ->add('client')
            ->add('vehicule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurance::class,
        ]);
    }
}
