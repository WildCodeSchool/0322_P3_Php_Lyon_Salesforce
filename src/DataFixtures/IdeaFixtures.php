<?php

namespace App\DataFixtures;

use App\Entity\Idea;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IdeaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $perimeters = [
            'Service RH France',
            'Service RH Est',
            'Service Informatique Nord',
            'Service Technique Sud',
            'Service Technique Paris',
            'Service Informatique Lyon',
            'Service Comptabilité Brest',
            'Service Technique Brest',
            'Service Comptabilité France',
        ];

        for ($i = 1; $i <= 50; $i++) {
            $idea = new Idea();

            $idea->setTitle($faker->word());
            $chosenPerimeters = $faker->randomElements($perimeters, rand(1, 6));
            foreach ($chosenPerimeters as $perimeter) {
                $idea->setPerimeter($perimeter);
            }


            $manager->persist($idea);
        }
        $manager->flush();
    }
}
