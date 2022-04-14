<?php

namespace App\Form;

use App\Entity\VoyageOrganise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoyageOrganiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idvoy')
            ->add('pays')
            ->add('date')
            ->add('nbjours')
            ->add('programme')
            ->add('tarif')
            ->add('nbanimal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VoyageOrganise::class,
        ]);
    }
}
