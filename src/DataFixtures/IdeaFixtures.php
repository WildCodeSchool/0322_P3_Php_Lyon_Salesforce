<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IdeaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $perimeters = [
            'Global',
            'Agence',
            'Service',
        ];


        for ($j = 1; $j <= 15; $j++) {
            $dummyIdea = new Idea();
            $dummyIdea->setTitle($faker->sentence());
            $dummyIdea->setContent($faker->paragraphs(5, true));

            $chosenPerimeters = $faker->randomElements($perimeters, rand(1, 3));
            foreach ($chosenPerimeters as $perimeter) {
                $dummyIdea->setPerimeter($perimeter);
            }

            $dummyIdea->setArchived(false);
            $dummyIdea->setPublicationDate(new DateTimeImmutable($faker->date()));
            $dummyIdea->setAuthor($this->getReference('contributor@sf.com'));

            $loopTurn = rand(4, 20);
            for ($j = 0; $j < $loopTurn; $j++) {
                $dummyIdea->addSupporter(
                    $this->getReference('user_' . $faker->numberBetween(1, 10) . '_Lyon')
                );
            }

            $manager->persist($dummyIdea);
        }

        foreach (OfficeFixtures::OFFICES as $officeLocation) {
            for ($i = 1; $i <= 20; $i++) {
                $idea = new Idea();
                $idea->setTitle($faker->sentence());
                $idea->setContent($faker->paragraphs(5, true));

                $chosenPerimeters = $faker->randomElements($perimeters, rand(1, 3));
                foreach ($chosenPerimeters as $perimeter) {
                    $idea->setPerimeter($perimeter);
                }
                $idea->setArchived(false);
                $idea->setPublicationDate(new DateTimeImmutable($faker->date()));
                $idea->setAuthor($this->getReference('user_' . $faker->numberBetween(1, 10) . '_' . $officeLocation));

                $loopTurn = rand(4, 20);
                for ($j = 0; $j < $loopTurn; $j++) {
                    $idea->addSupporter(
                        $this->getReference('user_' . $faker->numberBetween(1, 10) . '_' . $officeLocation)
                    );
                }

                $manager->persist($idea);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
