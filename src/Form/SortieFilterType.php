<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('campus', EntityType::class, [
                'label' => 'Campus: ',
                'class' => Campus::class,
                'choice_label' => 'nomCampus',
                'required' => false
            ])
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('dateDebut', DateType::class, [
                'required' => false
            ])
            ->add('dateCloture', DateType::class, [
                'required' => false
            ])
            ->add('isOrganisateur', CheckboxType::class, [
                'required' => false
            ])
            ->add('isInscrit', CheckboxType::class, [
                'required' => false
            ])
            ->add('notInscrit', CheckboxType::class, [
                'required' => false
            ])
            ->add('isOnlyOld', CheckboxType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
