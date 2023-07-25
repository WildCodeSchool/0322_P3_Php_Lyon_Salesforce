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
                'slackId' => 'U05FRL12VAN', 'password' => 'Thom123', 'profile-picture' => 'profile-picture-1.jpg',
            ],
            [
                'email' => 'ludovicd@sf.com',
                'firstname' => 'Ludovic', 'lastname' => 'Dormoy',
                'contactNumber' => '0607080902', 'department' => 'Informatique',
                'slackId' => 'U05FC162V51', 'password' => 'Ludo123', 'profile-picture' => 'profile-picture-2.jpg',
            ],
            [
                'email' => 'benjaminr@sf.com',
                'firstname' => 'Benjamin', 'lastname' => 'Richard',
                'contactNumber' => '0607080903', 'department' => 'Informatique',
                'slackId' => 'U05FAV754LT', 'password' => 'Ben123', 'profile-picture' => 'profile-picture-3.jpg',
            ],
            [
                'email' => 'baptister@sf.com',
                'firstname' => 'Baptiste', 'lastname' => 'Renier',
                'contactNumber' => '0607080904', 'department' => 'Informatique',
                'slackId' => 'U05F47PANKY', 'password' => 'Bapt123', 'profile-picture' => 'profile-picture-4.jpg',
            ],
            [
                'email' => 'aurelienf@sf.com',
                'firstname' => 'Aurelien', 'lastname' => 'Faure',
                'contactNumber' => '0607080901', 'department' => 'Informatique',
                'slackId' => 'U05E6QELLJ2', 'password' => 'Aurel123', 'profile-picture' => 'profile-picture-5.jpg',
            ],
            [
                'email' => 'anthonyp@sf.com',
                'firstname' => 'Anthony', 'lastname' => 'Pham',
                'contactNumber' => '0707080901', 'department' => 'Informatique',
                'slackId' => 'U05GQ1K5N5C', 'password' => 'Antho123', 'profile-picture' => 'profile-picture-8.jpg',
            ],
            [
                'email' => 'valentini@sf.com',
                'firstname' => 'Valentin', 'lastname' => 'Inacio',
                'contactNumber' => '0701080901', 'department' => 'Informatique',
                'slackId' => 'U05GGEW9G23', 'password' => 'Val123', 'profile-picture' => '',
            ],
            [
                'email' => 'gwendolinen@sf.com',
                'firstname' => 'Gwendoline', 'lastname' => 'NGuon',
                'contactNumber' => '0706080901', 'department' => 'Informatique',
                'slackId' => 'U05GPQUQ79U', 'password' => 'Gwen123', 'profile-picture' => 'profile-picture-7.jpg',
            ],
            [
                'email' => 'fredericm@sf.com',
                'firstname' => 'Frédéric', 'lastname' => 'Moutin',
                'contactNumber' => '0606060901', 'department' => 'Informatique',
                'slackId' => 'U05GWA86PDG', 'password' => 'Fred123', 'profile-picture' => '',
            ],
            [
                'email' => 'laetitiab@sf.com',
                'firstname' => 'Laetitia', 'lastname' => 'Biny',
                'contactNumber' => '0606060201', 'department' => 'Informatique',
                'slackId' => 'U05HL2TJ88G', 'password' => 'Laeti123', 'profile-picture' => 'profile-picture-6.jpg',
            ],
        ];

        foreach ($usersData as $index => $userData) {
            $realUser = new User();
            $realUser->setEmail($userData['email']);
            $realUser->setFirstname($userData['firstname']);
            $realUser->setLastname($userData['lastname']);
            $realUser->setPictureFileName($userData['profile-picture']);
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
