<?php

namespace App\Form;

use App\Entity\ParticipationVoyage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationVoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_user')
            ->add('id_voyage')
            ->add('nomUser')
            ->add('prenomUser')
            ->add('dateVoyage')
            ->add('paysVoyage')
            ->add('tarifVoyage')
            ->add('nbanimalVoyage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ParticipationVoyage::class,
        ]);
    }
}
