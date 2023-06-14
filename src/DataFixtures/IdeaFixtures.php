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



        for ($i = 1; $i <= 50; $i++) {
            $idea = new Idea();

            $idea->setTitle($faker->word());
            $chosenPerimeters = $faker->randomElements($perimeters, rand(1, 3));
            foreach ($chosenPerimeters as $perimeter) {
                $idea->setPerimeter($perimeter);
            }

            $idea->setPublicationDate(new DateTimeImmutable());
            $idea->setAuthor($this->getReference('user_superadmin@sf.com'));


            $manager->persist($idea);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          UserFixtures::class,
        ];
    }
}
