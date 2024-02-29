<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Nationality;

class NationalityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
            'Canadien',
            'Australien',
        ];

        foreach ($country as $i => $value) {
            $nationality = new Nationality();
            $nationality->setNationality($value);
            $manager->persist($nationality);
            $this->addReference('nationality_' . $i, $nationality);
        }

        $manager->flush();
    }
}
