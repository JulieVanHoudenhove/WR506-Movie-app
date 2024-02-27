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
        $characters = array(':', '!', '?', '.', ',', '(', ')', '\'', '’', 'é', 'è', 'à', 'ç', 'ê', 'â', 'î', 'ô', 'û', 'ä', 'ë', 'ü', 'ï', 'ö', 'ù', 'ÿ', 'ñ', 'æ', 'œ');

        foreach (range(1, 40) as $i) {
            $movie = new Movie();
            $movie->setCategory($this->getReference('category_' . rand(1, 5)));
            $movie->setTitle($faker->unique()->movie);
            $movie->setDescription('Lorem ipsum dolor sit amet, consectetur tincidunt.' . $i);
            $movie->setReleaseDate($faker->dateTimeBetween($startDate = '-30 years', 'now', $timezone = null));
            $movie->setDuration(rand(60, 180));
            $movie->setUser($this->getReference('user_' . rand(1, 5)));
            $movie->setOnline((bool) rand(0, 1));
            $movie->setNote(rand(0, 5));
            $movie->setEntries(rand(0, 1000000));
            $movie->setBudget(rand(0, 100000000));
            $movie->setDirector('Director' . rand(1, 5));
            $removeChars = strtolower(str_replace($characters, '', $movie->getTitle()));
            $website = str_replace(' ', '-', $removeChars);
            $movie->setWebsite('https://www.' . $website . '.com');
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
            UserFixtures::class,
        ];
    }
}
