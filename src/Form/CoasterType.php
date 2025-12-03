<?php

namespace App\Form;

use App\Entity\Coaster;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Park;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoasterType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void
    {
        $builder
            ->add('name')
            ->add('maxSpeed')
            ->add('length')
            ->add('maxHeight')
            ->add('park', EntityType::class, [
                'class' => Park::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner un parc',
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner des catégories',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,  // ⭐ Ajoute ceci
            ])
            ->add('operating')
        ;
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }

    
}



