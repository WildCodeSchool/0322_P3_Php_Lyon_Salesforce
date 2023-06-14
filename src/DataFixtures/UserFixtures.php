<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        foreach (OfficeFixtures::OFFICES as $officeLocation) {
            for ($i = 1; $i <= 10; $i++) {
                $email = $faker->unique()->safeEmail;

                $contributor = new User();
                $contributor->setEmail($email);
                $contributor->setFirstname($faker->firstName());
                $contributor->setLastname($faker->lastName());
                $contributor->setDepartment($faker->word());
                $contributor->setProfilePicture($faker->image());
                $contributor->setPosition($faker->jobTitle());
                $contributor->setWorkplace($this->getReference('office_' . $officeLocation));
                $contributor->setRoles(['ROLE_CONTRIBUTOR']);
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $contributor,
                    'contributorpassword'
                );

                $contributor->setPassword($hashedPassword);
                $manager->persist($contributor);
                $this->addReference('user_' . $i  . '_' . $officeLocation, $contributor);
            }
        }



        $dummyContributor = new User();
        $dummyContributor->setEmail('contributor@sf.com');
        $dummyContributor->setFirstname('Bob');
        $dummyContributor->setLastname('Dylan');
        $dummyContributor->setDepartment('Comptabilité');
        $dummyContributor->setProfilePicture($faker->image(null, 640, 480));
        $dummyContributor->setPosition('Directeur');
        $dummyContributor->setWorkplace($this->getReference('office_' . $officeLocation));
        $dummyContributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $dummyContributor,
            'contributorpassword'
        );


        $dummyContributor->setPassword($hashedPassword);
        $manager->persist($dummyContributor);
        $this->addReference('contributor@sf.com', $dummyContributor);




        $admin = new User();
        $admin->setEmail('superadmin@sf.com');
        $admin->setFirstname('Quentin');
        $admin->setLastname('Tarantino');
        $admin->setDepartment('Informatique');
        $admin->setProfilePicture($faker->image());
        $admin->setPosition('Assistant Manager');
        $admin->setWorkplace($this->getReference('office_' . $officeLocation));
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }




    public function getDependencies()
    {
        return [
          OfficeFixtures::class,
        ];
    }
}
