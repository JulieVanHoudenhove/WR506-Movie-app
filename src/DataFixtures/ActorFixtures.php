<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Person($faker));

        foreach (range(1, 20) as $i) {
            $actor = new Actor();
            $fullname = $faker->unique()->actor;
            $actor->setfirstName(substr($fullname, 0, strpos($fullname, ' ')));
            $actor->setlastName(substr($fullname, strpos($fullname, ' ') + 1));
//            $actor->setreward($rewards[rand(0, 9)]);
            $actor->setNationality($this->getReference('nationality_' . rand(1, 10)));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            NationalityFixtures::class,
        ];
    }
}
