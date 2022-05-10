<?php

namespace App\Form;

use App\Entity\EvenementLocal;
use App\Entity\Utilisateur;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class EvenementLocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom', TextType::class, array('label'  => 'Nom', 'attr'   =>  array('class'   => 'form-control')))
            ->add('date', DateType::class, array('label'  => 'Date', 'attr'   =>  array('class'   => 'form-control datetimepicker-input')))
            ->add('nbparti',TextType::class, array('label'  => 'Nombre de participants', 'attr'   =>  array('class'   => 'form-control')))
            ->add('tarif',TextType::class, array('label'  => 'Tarif', 'attr'   =>  array('class'   => 'form-control')))
            ->add('lieu',TextType::class, array('label'  => 'Lieu', 'attr'   =>  array('class'   => 'form-control')))
            ->add('description',TextType::class, array('label'  => 'Descrption', 'attr'   =>  array('class'   => 'form-control')))
            ->add('nbplace',TextType::class, array('label'  => 'Nombre De Places', 'attr'   =>  array('class'   => 'form-control')))

            ->add('image', FileType::class, [
                'label' => 'photo ','attr'   =>  array('class'   => 'form-control'),

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EvenementLocal::class,
        ]);
    }
}
