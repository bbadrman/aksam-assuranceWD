<?php

namespace App\Form;

 
use App\Entity\Prospect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;


class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', Type\TextType::class, [
            'label' => 'Nom *',
            'attr' => [

                'placeholder' => 'Tapez le Nom du Client'
            ],
            'required' => true,
            'constraints' => new NotBlank(['message' => 'ne peut pas etre vide'])
        ])
        ->add('lastname', Type\TextType::class, [
            'label' => 'Prenom *',
            'attr' => [

                'placeholder' => 'Tapez le Prénom du Client'
            ],
            'required' => true,
           
        ])
            ->add('phone', Type\TelType::class, [
                'label' => 'Téléphone 1 *',
                'required' => true,
                
                'attr' => [
                    'placeholder' => 'Merci de saisir le numéro de téléphone'
                ]
            ])
            ->add('email', Type\EmailType::class, [
                'label' => 'Email *',
                'required' => false,
                'attr' => [
                    'placeholder' => "Merci de saisir l'adresse email"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
