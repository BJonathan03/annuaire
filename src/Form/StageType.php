<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{

    private function getConfiguration($label, $placeholder, $options = []){
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder,
                'class' => 'form-control'
            ]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                $this->getConfiguration("Titre du stage", "Titre de votre stage" )
            )
            ->add(
                'description',
                TextType::class,
                $this->getConfiguration("Déscription", "Brève déscription" )
            )
            ->add(
                'price',
                NumberType::class,
                $this->getConfiguration("Prix", "Prix du stage" )
            )
            ->add(
                'begin',
                DateType::class,
                $this->getConfiguration("Date de début", "" , [
                    'widget' => 'single_text',
                ])
            )
            ->add(
                'end',
                DateType::class,
                $this->getConfiguration("Date de fin", "" , [
                    'widget' => 'single_text',
                ])
            )
            ->add(
                'information',
                TextareaType::class,
                $this->getConfiguration("Information complémentaire", "Donnée plus de détails sur l'organisation, le contenu,..." )
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
