<?php

namespace App\DataFixtures;

use App\Entity\Office;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfficeFixtures extends Fixture
{
    public const OFFICES = [
        'Brest',
        'Paris',
        'Lyon',

    ];


    public function load(ObjectManager $manager): void
    {

        foreach (self::OFFICES as $officeLocation) {
            $office = new Office();
            $office->setLocation($officeLocation);

            $manager->persist($office);
            $manager->flush();

            $this->addReference('office_' . $officeLocation, $office);
        }
    }
}
