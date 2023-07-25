<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use League\Csv\Reader;

class RealIdeaFixtures extends Fixture implements DependentFixtureInterface
{
    private Reader $csvReader;

    public function __construct()
    {
        $this->csvReader = Reader::createFromPath('assets\Import\csv-ideas.csv');
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $perimeters = [
            'Global',
            'Agence',
            'Service',
        ];

        $records = $this->filterFile();

        foreach ($records as $record) {
            $date = $faker->dateTimeBetween('-40 days');
            $publicationDate = DateTimeImmutable::createFromMutable($date);
            $endDate = $publicationDate->modify('+31 days');

            $idea = new Idea();
            $idea->setTitle($record['title']);
            $idea->setContent($record['content']);
            $chosenPerimeters = $faker->randomElements($perimeters, rand(1, 3));
            foreach ($chosenPerimeters as $perimeter) {
                $idea->setPerimeter($perimeter);
            }
            $idea->setArchived(false);
            $idea->setPublicationDate($publicationDate);
            $idea->setEndDate($endDate);
            $idea->setAuthor($this->getReference('user_' . $faker->numberBetween(1, 10)));

            for ($j = 0; $j < rand(4, 20); $j++) {
                $idea->addSupporter(
                    $this->getReference('user_' . $faker->numberBetween(2, 10))
                );
            }

            $manager->persist($idea);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RealUserFixtures::class,
        ];
    }

    protected function filterFile(): array
    {
        $this->csvReader->setDelimiter(':');
        $this->csvReader->setHeaderOffset(0);

        $records = $this->csvReader->getRecords();
        $ideas = [];
        foreach ($records as $record) {
            $title = $record['title'];
            $content = $record['content'];

            $ideas[] = [
                'title' => $title,
                'content' => $content,
            ];
        }
        return $ideas;
    }
}
