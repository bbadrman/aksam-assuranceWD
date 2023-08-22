<?php

namespace App\Form;

use App\Search\SearchUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', Type\TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('status', Type\ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Active' => 1,
                    'Desactive' => 0
                ],
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Status'
            ])
            ->add('gender', Type\ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'Male' => 1,
                    'Female' => 0
                ],
                'expanded' => false,
                'multiple' => false,    
                 'placeholder' => 'Gender'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchUser::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

}