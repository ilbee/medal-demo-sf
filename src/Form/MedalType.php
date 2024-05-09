<?php

namespace App\Form;

use App\Entity\Medal;
use App\Entity\Nation;
use App\Entity\Sport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', ChoiceType::class, [
                'choices' => [
                    'Or' => Medal::COLOR_OR,
                    'Argent' => Medal::COLOR_ARGENT,
                    'Bronze' => Medal::COLOR_BRONZE,
                ],
                'label' => 'Couleur de la médaille',
                'autocomplete' => true,
            ])
            ->add('sport', SportAutocompleteField::class)
            ->add('nation', NationAutocompleteField::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medal::class,
        ]);
    }
}
