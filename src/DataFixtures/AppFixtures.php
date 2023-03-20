<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++){
            $category = new Category();
            $category->setTitle('parent '.$i);

            for ($k = 0; $k < 5; $k++){
                $categoryChild = new Category();
                $categoryChild->setTitle('child '.$i.'-'.$k);
                $categoryChild->setParent($category);
                $manager->persist($categoryChild);
            }

            $manager->persist($category);
        }

        $manager->flush();
    }
}
