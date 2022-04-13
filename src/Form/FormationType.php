<?php

namespace App\Form;

use App\Entity\Formations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titres', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('organismes', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('logo', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('periode', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-3'  
                ]
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class, 
        ]);
    }
}
