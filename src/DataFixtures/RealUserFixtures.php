<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RealUserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $officeLocation = 'Lyon';

        $usersData = [
            [
                'email' => 'thomasa@sf.com',
                'firstname' => 'Thomas', 'lastname' => 'Aldaitz',
                'contactNumber' => '0606060606', 'department' => 'Informatique',
                'slackId' => 'U05FRL12VAN', 'password' => 'Thom123',
            ],
            [
                'email' => 'ludovicd@sf.com',
                'firstname' => 'Ludovic', 'lastname' => 'Dormoy',
                'contactNumber' => '0607080902', 'department' => 'Informatique',
                'slackId' => 'U05FC162V51', 'password' => 'Ludo123',
            ],
            [
                'email' => 'benjaminr@sf.com',
                'firstname' => 'Benjamin', 'lastname' => 'Richard',
                'contactNumber' => '0607080903', 'department' => 'Informatique',
                'slackId' => 'U05FAV754LT', 'password' => 'Ben123',
            ],
            [
                'email' => 'baptister@sf.com',
                'firstname' => 'Baptiste', 'lastname' => 'Renier',
                'contactNumber' => '0607080904', 'department' => 'Informatique',
                'slackId' => 'U05F47PANKY', 'password' => 'Bapt123',
            ],
            [
                'email' => 'aurelienf@sf.com',
                'firstname' => 'Aurelien', 'lastname' => 'Faure',
                'contactNumber' => '0607080901', 'department' => 'Informatique',
                'slackId' => 'U05E6QELLJ2', 'password' => 'Aurel123',
            ],
            [
                'email' => 'anthonyp@sf.com',
                'firstname' => 'Anthony', 'lastname' => 'Pham',
                'contactNumber' => '0707080901', 'department' => 'Informatique',
                'slackId' => 'D05HLCCNAQG', 'password' => 'Antho123',
            ],
            [
                'email' => 'valentini@sf.com',
                'firstname' => 'Valentin', 'lastname' => 'Inacio',
                'contactNumber' => '0701080901', 'department' => 'Informatique',
                'slackId' => 'D05GQBAPYF8', 'password' => 'Val123',
            ],
            [
                'email' => 'gwendolinen@sf.com',
                'firstname' => 'Gwendoline', 'lastname' => 'NGuon',
                'contactNumber' => '0706080901', 'department' => 'Informatique',
                'slackId' => 'D05GWEW81EW', 'password' => 'Gwen123',
            ],
            [
                'email' => 'fredericm@sf.com',
                'firstname' => 'Frédéric', 'lastname' => 'Moutin',
                'contactNumber' => '0606060901', 'department' => 'Informatique',
                'slackId' => 'D05GYPBA6DS', 'password' => 'Fred123',
            ],
            [
                'email' => 'laetitiab@sf.com',
                'firstname' => 'Laetitia', 'lastname' => 'Biny',
                'contactNumber' => '0606060201', 'department' => 'Informatique',
                'slackId' => 'D05GYQJMX1A', 'password' => 'Laeti123',
            ],
        ];

        foreach ($usersData as $index => $userData) {
            $realUser = new User();
            $realUser->setEmail($userData['email']);
            $realUser->setFirstname($userData['firstname']);
            $realUser->setLastname($userData['lastname']);
            $realUser->setContactNumber($userData['contactNumber']);
            $realUser->setDepartment($userData['department']);
            $realUser->setWorkplace($this->getReference('office_' . $officeLocation));
            $realUser->setRoles(['ROLE_USER']);
            $realUser->setSlackId($userData['slackId']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $realUser,
                $userData['password']
            );

            $realUser->setPassword($hashedPassword);

            $manager->persist($realUser);
            $this->addReference('user_' . ($index + 1), $realUser);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OfficeFixtures::class,
        ];
    }
}
