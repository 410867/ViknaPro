<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\EventSubscriber\Entity\CategoryNestingGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++){
            $category = new Category();
            $category->setTitle('parent '.$i);
            $manager->persist($category);
            $category->setNesting(CategoryNestingGenerator::generate($category));

            for ($k = 0; $k < 5; $k++){
                $categoryChild = new Category();
                $categoryChild->setTitle('child '.$i.'-'.$k);
                $categoryChild->setParent($category);
                $manager->persist($categoryChild);

                $categoryChild->setNesting(CategoryNestingGenerator::generate($categoryChild));
            }
        }

        $manager->flush();
    }
}
