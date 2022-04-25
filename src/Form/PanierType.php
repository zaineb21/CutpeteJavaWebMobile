<?php

namespace App\Form;

use App\Entity\CodePromo;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder


            ->add('quantitePanier')
            ->add('idUtulisateur',
                EntityType::class,
                ['label'=>'nom de utulisateur','class'=>Utilisateur::class,
                    'choice_label'=>'nom','multiple'=>false,'expanded'=>false])
            ->add('idProduit',
                EntityType::class,
                ['label'=>'idProduit','class'=>Produit::class,
                    'choice_label'=>'id_produit','multiple'=>false,'expanded'=>false])
        ->add('codePromo',
        EntityType::class,
        ['label'=>'idCodepromo','class'=>CodePromo::class,
            'choice_label'=>'id_codepromo','multiple'=>false,'expanded'=>false]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Panier::class,
        ]);
    }
}
