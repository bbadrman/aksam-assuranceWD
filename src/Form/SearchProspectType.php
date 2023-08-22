<?php

namespace App\Form;

use Type\DateType;
use App\Entity\Team;
use App\Search\SearchProspect;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;

class SearchProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', Type\TextType::class, [
                
                'label' => "Nom :",
                'attr' => [
                    'placeholder' => "Recherche par nom du client."
                ],
               
                'required' => false
            ])
            ->add('m', Type\TextType::class, [
                
                'label' => "Prenom :",
                'attr' => [
                    'placeholder' => "Recherche par prenom du client."
                ],
                'required' => false
            ])
            ->add('g', Type\TextType::class, [
                'label' => "E-mail :",
                'attr' => [
                    'placeholder' => "Recherche par E-mail."
                ],
                'required' => false
            ])
            ->add('c', Type\TextType::class, [
                'label' => "Ville :",
                'attr' => [
                    'placeholder' => "Recherche par ville."
                ],
                'required' => false
            ])
            ->add('l', Type\TextType::class, [
                'label' => "Telephone :",
                'attr' => [
                    'placeholder' => "Recherche par numero telephone du client."
                ],
                'required' => false
            ])
            ->add('team', Type\TextType::class, [
                'label' => "Equipe :",
                'attr' => [
                    'placeholder' => "Recherche par nom d'equipe."
                ],
                'required' => false
            ])
            ->add('d', Type\DateType::class, [
                'label' => "Date :",
                
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => "date format: yyyy-mm-dd."
                ],
                'required' => false
            ])
            ->add('d', Type\DateType::class, [
                'label' => "Du :",
                
                'widget' => 'single_text',
               
               
                'attr' => [
                    'placeholder' => "date format: yyyy-mm-dd."
                ],
                'required' => false
            ])

            ->add('dd', Type\DateType::class, [
                'label' => "Ou :",
                
                'widget' => 'single_text',
                'attr' => [ 
                    'placeholder' => "date format: yyyy-mm-dd."
                ],
                'required' => false
            ])

            ->add('r', Type\TextType::class, [
                'label' => "Comercielle :",
                'attr' => [
                    'placeholder' => "Recherche par nom du Comercielle."
                ],
                'required' => false
            ])
            ->add('s', Type\TextType::class, [
                'label' => "r-sociale :",
                'attr' => [
                    'placeholder' => "Recherche par r-sociale."
                ],
                'required' => false
            ])
            
            ->add('source', Type\ChoiceType::class, [
                'label' => 'Source :',
                'required' => false,
                'placeholder' => '--Merci de selectie-- ',
                'choices' => [
                    'Propre site' => 'Propre site',
                    'Saisie manuelle' => 'Saisie manuelle',
                    'Revendeur' => 'Revendeur',
                ],
                'expanded' => false,
                'multiple' => false
            ])
            
         ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchProspect::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

}