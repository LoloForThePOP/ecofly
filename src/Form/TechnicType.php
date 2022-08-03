<?php

namespace App\Form;

use App\Entity\Technic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
                    'label' => 'Quel est le nom de la technique ?',
                    'attr' => [
                        
                        'placeholder'    => 'Exemple : carburants synthétiques',
                    ],

                    'required'   => true,
                ]
            )

            ->add(
                'textDescription',
                TextareaType::class,
                [
                    'label' => 'Décrire la technique en quelques mots ou paragraphes',
                    'required'     => false,
                    'sanitize_html' => true,
                    'attr' => [
                        'class' => "tinymce",
                    ],
                ]
            )

            ->add(
                'pros',
                TextareaType::class,
                [
                    'label' => '🙂 intérêts / avantages de la technique ?',
                    'required'     => false,
                    'sanitize_html' => true,
                    'attr' => [
                        'class' => "tinymceProsCons",
                    ],
                ]
            )

            ->add(
                'cons',
                TextareaType::class,
                [
                    'label' => '🤔 limites / inconvénients  de la technique ?',
                    'required'     => false,
                    'sanitize_html' => true,
                    'attr' => [
                        'class' => "tinymceProsCons",
                    ],
                ]
            )

            ->add(
                'progressBar',
                IntegerType::class,
                [
                    'label' => 'Pourcentage de décarbonation entre 1 et 100 ?',
                    'required'     => false,
                    'attr'     => array(
                        'min'  => 1,
                        'max'  => 100,
                        'step' => 1,
                    ),
                ]
            )


        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Technic::class,
        ]);
    }
}
