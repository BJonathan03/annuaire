<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
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
                'adresse',
                TextType::class,
                $this->getConfiguration("Adresse de l'entreprise", "Rue de la grande ourse " )
            )
            ->add(
                'number',
                NumberType::class,
                $this->getConfiguration("Numéro", "124")
            )
            ->add(
                'password',
                PasswordType::class,
                $this->getConfiguration('Mot de passe', 'Choisissez un bon mot de passe...'))
            ->add(
                'name',
                TextType::class,
                $this->getConfiguration("Votre nom", "John")
            ) ->add(
                'familyName',
                TextType::class,
                $this->getConfiguration("Votre nom de famille", "Doe")
            )
            ->add(
                'newsLetter',
                ChoiceType::class,[
                    'choices' => [
                        'Oui' => 'oui',
                        'Non' => 'non'
                    ]
            ]
            )
            ->add('cp')
            ->add('locality')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
