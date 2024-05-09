<?php

namespace App\Form;

use App\Entity\Nation;
use App\Repository\NationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class NationAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Nation::class,
            'placeholder' => 'Choisissez une nation',
            'choice_label' => 'name',
            'no_results_found_text' => 'Aucune nation trouvée',
            'no_more_results_text'  => 'Aucune autre nation',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
