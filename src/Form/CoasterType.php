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
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CoasterType extends AbstractType
{
    private AuthorizationCheckerInterface $authChecker;
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
        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            $builder->add('published', CheckboxType::class, [
                'label' => 'Publier cette fiche',
                'required' => false,
            ]);
        }
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }

    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }
}



