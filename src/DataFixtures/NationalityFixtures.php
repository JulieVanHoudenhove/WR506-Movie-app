<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Nationality;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $country = [
            'Français',
            'Américain',
            'Anglais',
            'Allemand',
            'Espagnol',
            'Italien',
            'Japonais',
            'Chinois',
            'Russe',
            'Canadien'
        ];

        foreach (range(1, 10) as $i) {
            $nationality = new Nationality();
            $nationality->setNationality($country[rand(0, 9)]);
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}
