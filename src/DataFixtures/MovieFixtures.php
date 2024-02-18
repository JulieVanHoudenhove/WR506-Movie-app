<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Movie;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

        foreach (range(1, 40) as $i) {
            $movie = new Movie();
            $movie->setTitle($faker->unique()->movie);
            $movie->setDescription('Synopsis ' . $i);
            $movie->setDuration(rand(60, 180));
            $movie->setOnline((bool) rand(0, 1));
            $movie->setReleaseDate($faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null));
            $movie->setCategory($this->getReference('category_' . rand(1, 5)));
            $movie->setDirector('Director' . rand(1, 5));
            foreach (range(1, rand(1, 5)) as $j) {
                $movie->addActor($this->getReference('actor_' . rand(1, 20)));
            }
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ActorFixtures::class,
        ];
    }
}
