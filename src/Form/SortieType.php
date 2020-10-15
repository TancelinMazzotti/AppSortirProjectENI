<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieux;
use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom: ',
                'required' => true
            ])

            ->add('dateDebut', DateType::class, [
                'label' => 'Date de début: ',
                'format' => 'dd/MM/yyyy',
                'required' => true
            ])

            ->add('duree', NumberType::class, [
                'label' => 'Durée: ',
                'required' => true
            ])

            ->add('dateCloture', DateType::class, [
                'label' => 'Date de cloture: ',
                'format' => 'dd/MM/yyyy',
                'required' => true
            ])

            ->add('nbInscriptionMax', NumberType::class, [
                'label' => 'Nombre d\'inscription: ',
                'required' => true
            ])

            ->add('descriptionInfo', TextareaType::class, [
                'label' => 'Description: '
            ])

            ->add('campus', EntityType::class, [
                'label' => 'Campus: ',
                'class' => Campus::class,
                'choice_label' => 'nomCampus',
                'required' => true
            ])

            ->add('etat', EntityType::class, [
                'label' => 'Etat: ',
                'class' => Etat::class,
                'choice_label' => 'libelle',
                'required' => true
            ])

            ->add('lieux', EntityType::class, [
                'label' => 'Lieux: ',
                'class' => Lieux::class,
                'choice_label' => 'nom',
                'required' => true
            ])

            ->add('organisateur', EntityType::class, [
                'label' => 'Organisateur: ',
                'class' => Participant::class,
                'choice_label' => 'pseudo',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
