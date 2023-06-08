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

        for ($i = 1; $i <= 50; $i++) {
            $idea = new Idea();
            ;
            $idea->setTitle($faker->word());
            $idea->setPerimeter($faker->word());

            $manager->persist($idea);
        }
        $manager->flush();
    }
}
