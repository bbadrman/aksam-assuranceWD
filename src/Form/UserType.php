<?php

namespace App\Form;

use App\Entity\Fonction;
use App\Entity\Team;
use App\Entity\User; 
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\TeamRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType

{ 
   
    private $productRepository;
    
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }
         


    public function buildForm(FormBuilderInterface $builder,  array $options): void
    {   
    
        
              
        $builder
                

        ->add('username', Type\TextType::class, [
            'label' => 'Username',
            'error_bubbling' => false,      
            'required' => true,
            'attr' => [
                'placeholder' => "Merci de saisir Username"
            ]
        ])
            ->add('fonctions')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                     
                        'Tous' => 'ROLE_ADMIN',
                        'Chef Equipe'   => 'ROLE_TEAM',
                    
                       
                    '*-----Prospects-----*' => [
                        'Gestion Prospects' => 'ROLE_PROS',
                        'Ajouter Prospect'  => 'ROLE_ADD_PROS',
                        'Edite Prospect'    => 'ROLE_EDIT_PROS',
                    ],
                    '*-----Standard-----*' => [
                        'Gestion Standard' => 'ROLE_STAND',
                        'Ajouter Standard' => 'ROLE_ADD_STAND',
                        'Edite Standard'   => 'ROLE_EDIT_STAND',
                    ],
                    '*-----Produit-----*' => [
                        'Gestion Produit'  => 'ROLE_PROD',
                        'Ajouter Produit'  => 'ROLE_ADD_PROD',
                        'Edite Produit'  => 'ROLE_EDIT_PROD',
                    ],
                    '*-----RH-----*' => [

                        'Gestion RH' => 'ROLE_RH',
                        'Ajouter RH' => 'ROLE_ADD_RH',
                        'Edite RH' => 'ROLE_EDIT_RH',
                    ],
                        
                    '*-----Clients-----*' => [
                        'Gestion Clients' => 'ROLE_CLIENT',
                        'Ajouter Client' => 'ROLE_ADD_CLIENT',
                        'Edite Client' => 'ROLE_EDIT_CLIENT',
                    ],
                ],


                
                'required' => false,
                'multiple' => true, 
                'label' => 'Rôles',
                'attr' => [
                    'placeholder' => '--choisir une fonction--',
                ]
            ])

            ->add('firstname', Type\TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Merci de saisir le prénom'
                ]
            ])
            ->add('lastname', Type\TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Merci de saisir le nom'
                ]
            ])
            
            ->add('embuchAt', Type\DateType::class, [
                'label' => "Date d'embauche",

                'widget' => 'single_text',

            ])
            ->add('remuneration', Type\MoneyType::class, [
                'label' => 'remuneration',
                'attr' => [

                    'placeholder' => 'Tapez   en Dhs',


                    'divisor' => 100,

                ],

            ])
            
            ->add('password', Type\RepeatedType::class, [
                'type' => Type\PasswordType::class,
                'required' => true,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir le mot de passe'
                    ],
                    'error_bubbling' => true
                ],
                'second_options' => [
                    'label' => 'Confirmez Mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de confirmez le mot de passe'
                    ],
                    'error_bubbling' => true
                ]
            ])
            ->add('gender', Type\ChoiceType::class, [
                'label' => 'Gender',
                'required' => true,
                'choices' => [
                    'Male' => 1,
                    'Female' => 0
                ],
                'expanded' => true,
                'multiple' => false
            ])

            ->add('status', Type\ChoiceType::class, [
                'label' => 'Status',
                'required' => true,
                'choices' => [
                    'Active' => 1,
                    'Desactive' => 0
                ],
                'expanded' => true,
                'multiple' => false
            ])
            
            ->add('products') 
            ->add('teams');
             
            
            }
    
        //     $formModifier = function (FormInterface $form, Team $team = null) {
        //         $product = $team === null ? [] : $this->productRepository->findByTeamOrderedByAscName($team);
            
        //         $form->add('products', EntityType::class, [
        //             'class' => Product::class,
        //             'choice_label' => 'name',
        //             'multiple' => true,
        //             'disabled' => $team === null,
        //             'placeholder' => 'Choose a product',
        //             'choices' => $product,
        //             'required' => false
        //         ]);
        //     };

        //     $builder->addEventListener(
        //         FormEvents::PRE_SET_DATA,
        //         function (FormEvent $event) use ($formModifier) {
        //             $data = $event->getData();
    
        //             $formModifier($event->getForm(), $data->getTeams());
        //         }
        //     ); 

        //     $builder->get('teams')->addEventListener(
        //         FormEvents::POST_SUBMIT,
        //         function (FormEvent $event) use ($formModifier) {
        //             $team = $event->getForm()->getData();
    
        //             $formModifier($event->getForm()->getParent(), $team);
        //         }
        //     );
        // }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
