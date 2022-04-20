<?php

namespace App\Form;

use App\Entity\MesProjets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProjetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('lien',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('images',TextType::class,['attr' => ['class' => 'form-control']])
            ->add('ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success mt-3'  
                ]
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesProjets::class,
        ]);
    }
}
