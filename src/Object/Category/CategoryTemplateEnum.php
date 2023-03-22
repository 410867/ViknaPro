<?php

namespace App\Object\Category;

use App\Form\Catalog\CategoryGalleryTemplateType;
use App\Form\Catalog\CategoryType;

enum CategoryTemplateEnum: string
{
    case SUB_CATEGORIES = 'SUB_CATEGORIES';
    case CATEGORY_COLLECTION = 'CATEGORY_COLLECTION';
    case PRODUCTS = 'PRODUCTS';
    case GALLERY = 'GALLERY';

    public function getFormType(): string
    {
        switch ($this){
            case self::SUB_CATEGORIES:
            case self::CATEGORY_COLLECTION:
            case self::PRODUCTS:
                return CategoryType::class;
            case self::GALLERY:
                return CategoryGalleryTemplateType::class;
        }
    }
}
