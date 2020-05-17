<?php

namespace App\Form;

use App\Entity\Guardian;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpinionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comentario', TextareaType::class,[
                'attr'=>[
                    'placeholder'=>'   
                    
   Escribe aqui tu opinion'
                ]
            ])
            ->add('autor',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Autor'
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
            'data_class' => Guardian::class,
        ]);
    }
}
