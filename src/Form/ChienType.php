<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Proprietaire; // <-- Ne pas oublier l'import de l'entité
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // <-- Ne pas oublier l'import de l'EntityType
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
        ;

        // Si l'utilisateur est un admin, on ajoute la liste déroulante des propriétaires
        if ($options['is_admin']) {
            $builder->add('proprietaire', EntityType::class, [
                'class' => Proprietaire::class,
                // Remplace 'nom' par l'attribut que tu veux afficher dans la liste (ex: 'prenom', 'email'...)
                'choice_label' => 'nom', 
                'placeholder' => '-- Choisissez un propriétaire --',
                'required' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
            // On déclare notre nouvelle option par défaut à false
            'is_admin' => false, 
        ]);
    }
}