<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $firstNames = ['John', 'Jane', 'Jack', 'Jill', 'Jim', 'Jenny', 'Joe', 'Jade', 'Jules', 'Jasper'];
        $lastNames = ['Doe', 'Float', 'Black', 'White', 'Green', 'Red', 'Blue', 'Yellow', 'Orange', 'Purple'];

        foreach (range(1, 10) as $i) {
            $actor = new Actor();
            $actor->setfirstName($firstNames[rand(0, 9)]);
            $actor->setlastName($lastNames[rand(0, 9)]);
            $actor->setNationality($this->getReference('nationality_' . rand(1, 10)));
            $this->addReference('actor_' . $i, $actor);

            $manager->persist($actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
        ];
    }
}
