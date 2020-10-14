<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddParticipantProfilType extends AbstractType
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
                'label' => 'Prénom :',
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
            ->add('pass',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe ne sont identique !',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du Mot de passe'],

            ])
            ->add('campus',EntityType::class,[
                'label' => 'Campus',
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'required' => true,
            ])
            ->add('picture',FileType::class,[
                'mapped' => false,
                'label' => 'Photo de profil',
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
