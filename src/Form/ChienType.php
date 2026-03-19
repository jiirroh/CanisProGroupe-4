<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Proprietaire; // <-- Ne pas oublier cet import
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // <-- Et celui-ci
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('race')
            ->add('age')
            // On ajoute le sélecteur de propriétaire ici :
            ->add('proprietaire', EntityType::class, [
                'class' => Proprietaire::class,
                'choice_label' => 'nom', // Affiche le nom du propriétaire dans la liste
                'label' => 'Propriétaire du chien',
                'placeholder' => 'Choisissez un propriétaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
        ]);
    }
}