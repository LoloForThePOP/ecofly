<?php

namespace App\Form;

use App\Entity\Technic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnicLogoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(

            'logoFile',
            VichImageType::class,

            [
                'label' => 'Vignette / logo pour représenter cette technique ?',

                'attr' => [

                    'placeholder'    => '',
                ],

                'required'   => false,

                'allow_delete' => true,
                'download_label' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
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
