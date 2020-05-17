<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nombre'
                ]
            ])

            ->add('apellido',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Apellido'
                ]
            ])

            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'Email'
                ]
            ])
 
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'placeholder'=>'****'
                ]
            ])

            ->add('ciudad',ChoiceType::class,[
                'choices'=>[
                    'Escoge tu ciudad'=> "",
                    'Madrid'=>'Madrid',
                    'Barcelona'=>'Barcelona',
                    'Valencia'=>'Valencia',
                ],
                'attr'=>[
                    'class'=>'campo-formulario',
                ]
            ])
        
            ->add('Enviar',SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
