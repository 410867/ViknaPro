<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::postPersist, method: 'postSave', entity: Category::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'postSave', entity: Category::class)]
final class CategoryNestingGenerator
{
    public function postSave(Category $category, LifecycleEventArgs $event): void
    {
        if ($category->getNesting()){
            return;
        }

        $category->setNesting(self::generate($category));
        $event->getObjectManager()->flush();
    }

    public static function generate(Category $category): string
    {
        $nestingIds = [];

        do {
            $nestingIds[] = $category->getId();
            $category = $category->getParent();
        } while ($category);

        return implode('_', array_reverse($nestingIds));
    }
}
