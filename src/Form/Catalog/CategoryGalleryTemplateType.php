<?php

namespace App\Form\Catalog;

use App\Form\ImageMultipleType;
use App\Form\VideoType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

final class CategoryGalleryTemplateType extends CategoryType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('images', ImageMultipleType::class, [
                'required' => false
            ])
            ->add('videoLinks', CollectionType::class, [
                'required' => false,
                'allow_delete' => true,
                'allow_add' => true,
                'entry_type' => VideoType::class
            ]);
    }
}
