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
        $characters = array(
            ':', '!', '?', '.', ',', '(', ')', '\'', '’', 'é', 'è', 'à', 'ç',
            'ê', 'â', 'î', 'ô', 'û', 'ä', 'ë', 'ü', 'ï', 'ö', 'ù', 'ÿ', 'ñ', 'æ', 'œ'
        );
        $filename = array(
            'sex_education.jpg', 'the_crown.jpg', 'black_mirror.jpg', 'riverdale.jpg', '13_reasons_why.jpg',
            'the_order.jpg', 'mortel.jpg', 'lupin.jpg', 'peaky_blinder.jpg', 'la_casa_de_papel.jpg',
            'titans.jpg', 'the_haunting_of_hill_house.jpg', 'warrior_nun.jpg', 'emily_in_paris.jpg',
            'le_jeu_de_la_dame.jpg', 'elite.jpg', 'arcane.jpg', 'stranger_things.jpg'
        );

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
            $movie->setFilename($filename[rand(0, 17)]);
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
