<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Type\IntegerType;
use App\Entity\Prospect;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProspectAffectType extends AbstractType
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
     
        ->add('team', EntityType::class, [
            'class' => Team::class,
            'choice_label' => 'name',
            'placeholder' => '--Choose a Team--',
            'query_builder' => fn (TeamRepository $teamRepository) =>
            $teamRepository->findAllTeamByAscNameQueryBuilder()
        ]);

        $formModifier = function (FormInterface $form, Team $team = null) {
           
            $comrcl = $team === null ? [] : $this->userRepository->findComrclByteamOrderedByAscName($team);
            //dd(team); //null
            //dd( $comrcl); //[]
            $form->add('comrcl', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                // 'disabled' => $team === null,
                'placeholder' => '--Choose a Comercial--',
                'choices' => $comrcl
            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier)  {
                $data = $event->getData();
                //dd($data);
                $formModifier($event->getForm(), $data->getTeam());
                // if ($options['editing'] === false ) {

                //     $formModifier($event->getForm(), $data->getTeam());
                // }
            }
        );

        
        $builder->get('team')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $team = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $team);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
            
        ]);
    }
}
