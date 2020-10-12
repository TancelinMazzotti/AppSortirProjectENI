<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo',TextType::class,[
                'label' => 'Pseudo :',
                'required' => true,
            ])
            ->add('nom',TextType::class,[
                'label' => 'Nom :',
                'required' => true,
            ])
            ->add('prenom',TextType::class,[
                'label' => 'Prenom :',
                'required' => true,
            ])
            ->add('telephone',TextType::class,[
                'label' => 'Téléphone :',
                'required' => true,
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email :',
                'required' => true,
            ])
            ->add('pass',PasswordType::class,[
                'label' => 'Mot de passe :',
                'required' => true,
            ])
            ->add('campus',EntityType::class,[
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'label' => 'Campus :',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
