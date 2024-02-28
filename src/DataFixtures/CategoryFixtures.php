<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Action',
            'Adventure',
            'Animation',
            'Comedy',
            'Crime',
            'Drama',
            'Fantasy',
            'Historical',
            'Horror',
            'Mystery',
            'Philosophical',
            'Political',
            'Romance',
            'Saga',
            'Satire',
            'Science fiction',
            'Social',
            'Thriller',
            'Urban',
            'Western',
        ];

        foreach (range(1, 20) as $i) {
            $category = new Category();
            $category->setName($categories[$i - 1]);
            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }
}
