<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idreser')
            ->add('iduser')
            ->add('nom')
            ->add('prenom')
            ->add('date_arrive')
            ->add('date_sortie')
            ->add('nbanimal')
            ->add('pension')
            ->add('dresseur')
            ->add('veterinaire')
            ->add('tarif')
            ->add('numtel')
            ->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
