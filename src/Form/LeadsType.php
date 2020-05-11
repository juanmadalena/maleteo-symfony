<?php

namespace App\Form;

use App\Entity\Leads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeadsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, [
                'attr'=>[
                    'class'=>'campo-formulario',
                ]
            ])
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=>'campo-formulario',
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
            'data_class' => Leads::class,
        ]);
    }
}
