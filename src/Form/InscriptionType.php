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
        $user = $options['user'];
        $builder
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'libelle',
            ])
            ->add('chien', EntityType::class, [
                'class' => Chien::class,
                'query_builder' => function ($er) use ($user) {
                    if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                        return $er->createQueryBuilder('c');
                    }
                    if (!$user || !$user->getProprietaire()) {
                        return $er->createQueryBuilder('c')->where('1=0');
                    }
                    return $er->createQueryBuilder('c')
                        ->join('c.proprietaire', 'p')
                        ->where('p.id = :proprietaireId')
                        ->setParameter('proprietaireId', $user->getProprietaire()->getId());
                },
                'choice_label' => 'nom',
                'label' => 'Choisir le chien',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
            'user' => null,
        ]);
    }
}
