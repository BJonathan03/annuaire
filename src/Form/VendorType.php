<?php

namespace App\Form;

use App\Entity\Vendor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VendorType extends AbstractType
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
                'name',
                TextType::class,
                $this->getConfiguration("Votre nom", "John")
            )
            ->add(
                'phone',
                TelType::class,
                $this->getConfiguration("Votre numéro de téléphone", "0032 212121")
            )
            ->add(
                'tva',
                TextType::class,
                $this->getConfiguration("Votre Tva", "125 - 12552 - 1236")
            )
            ->add(
                'website',
                UrlType::class,
                $this->getConfiguration("L'adresse de votre site web", "www.comete-de-Halley.com")
            )
            ->add('emailContact',
                EmailType::class,
                $this->getConfiguration("Votre mail de contact", "mon-entreprise@hotmail.com")
            )
            ->add('password',
                PasswordType::class,
                $this->getConfiguration("Votre mot de passe", "Veuillez entrez votre mot de passe")
            )
            ->add('cp')
            ->add('locality')
            ->add('service')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vendor::class,
        ]);
    }
}
