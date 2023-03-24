<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;

final class VideoType extends TextType
{
    public function getBlockPrefix(): string
    {
        return 'video';
    }
}