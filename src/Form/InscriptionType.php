<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Cours;
use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'libelle', // Affiche le nom du cours dans le formulaire
            ])
          ->add('chien', EntityType::class, [
    'class' => Chien::class,
    // On personnalise ce qui est affiché dans la liste
    'choice_label' => function (Chien $chien) {
        $proprio = $chien->getProprietaire();
        return $chien->getNom() . ' (Propriétaire : ' . $proprio->getPrenom() . ' ' . $proprio->getNom() . ')';
    },
    'label' => 'Choisir le chien',
])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
