<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('nom',TextType::class, array('label'  => 'Nom', 'attr'   =>  array('class'   => 'form-control border-0 p-4')))
            ->add('prenom',TextType::class, array('label'  => 'Prenom', 'attr'   =>  array('class'   => 'form-control border-0 p-4')))
            ->add('date_arrive',DateType::class, array('label'  => 'date arrive', 'attr'   =>  array('class'   => 'form-control border-0 p-4 datetimepicker-input')))
            ->add('date_sortie',DateType::class, array('label'  => 'date sortie', 'attr'   =>  array('class'   => 'form-control border-0 p-4 datetimepicker-input')))
            ->add('nbanimal',TextType::class, array('label'  => 'Nombre animal' , 'attr'  =>  array('class'   => 'form-control border-0 p-4')))
            ->add('numtel',TextType::class, array('label'  => 'Tel', 'attr'   =>  array('class'   => 'form-control border-0 p-4')))
                ->add('pension',ChoiceType::class, [
                    'choices' => [
                        'Demi-pension' => 1,
                        'Pension-normal' => 2,'Pension-Royale' => 3
                    ],'expanded' => true])
            ->add('dresseur',CheckboxType::class, ['label'  => 'Dresseur', 'required'   => false,'attr'  =>  array('class'   => 'form-control border-1 p-2 datetimepicker-input')])
            ->add('veterinaire',CheckboxType::class, ['label'  => 'veterinaire', 'required'   => false,'attr'  =>  array('class'   => 'form-control border-1 p-2 datetimepicker-input')])
            
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
