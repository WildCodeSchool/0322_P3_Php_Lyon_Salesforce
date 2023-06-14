<?php

namespace App\DataFixtures;

use App\Entity\Office;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OfficeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $brest = new Office();
        $brest->setLocation('Brest');

        $paris = new Office();
        $paris->setLocation('Paris');

        $lyon = new Office();
        $lyon->setLocation('Lyon');

        $manager->persist($brest);
        $manager->persist($paris);
        $manager->persist($lyon);


        $manager->flush();

        $this->addReference('office_brest', $brest);
        $this->addReference('office_paris', $paris);
        $this->addReference('office_lyon', $lyon);
    }
}
