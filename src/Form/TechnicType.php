<?php

namespace App\Form;

use App\Entity\Technic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TechnicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add(
                'name', 
                TextType::class,
                [
                    'label' => 'Donner un titre à la technique',
                    'attr' => [
                        
                        'placeholder'    => 'Écrire ici',
                    ],

                    'required'   => true,
                ]
            )

            ->add(
                'textDescription',
                TextareaType::class,
                [
                    'label' => 'Décrire la technique en quelques paragraphes',
                    'required'     => false,
                    'sanitize_html' => true,
                    'attr' => [
                        'class' => "tinymce",
                    ],
                ]
            );


        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technic::class,
        ]);
    }
}
