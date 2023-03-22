<?php

namespace App\Form\Catalog;

use Symfony\Component\Form\FormBuilderInterface;

final class CategoryGalleryTemplateType extends CategoryType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('images')
            ->add('videoLinks');
    }
}