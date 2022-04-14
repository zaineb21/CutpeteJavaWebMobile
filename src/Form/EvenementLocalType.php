<?php

namespace App\Form;

use App\Entity\EvenementLocal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idEve')
            ->add('nom')
            ->add('date')
            ->add('nbparti')
            ->add('tarif')
            ->add('lieu')
            ->add('description')
            ->add('nbplace')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EvenementLocal::class,
        ]);
    }
}
