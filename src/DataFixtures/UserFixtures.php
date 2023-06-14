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

   /*     $offices = [
            $this->getReference('office_brest'),
            $this->getReference('office_paris'),
            $this->getReference('office_lyon'),
        ];


        for ($i = 1; $i <= 50; $i++) {
            $contributor = new User();
            $contributor->setEmail($faker->unique()->safeEmail);
            $contributor->setFirstname($faker->firstName());
            $contributor->setLastname($faker->lastName());
            $contributor->setDepartment($faker->word());
            $contributor->setProfilePicture($faker->image(null, 640, 480));
            $contributor->setPosition($faker->jobTitle());

            $chosenOffices = $faker->randomElements($offices, rand(1, 3));
            foreach ($chosenOffices as $office) {
                $contributor->setWorkplace($office);
            }
            $contributor->setRoles(['ROLE_CONTRIBUTOR']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $contributor,
                'contributorpassword'
            );

            $contributor->setPassword($hashedPassword);
            $manager->persist($contributor);
        }


        $contributor = new User();
        $contributor->setEmail('contributor@sf.com');
        $contributor->setFirstname('Bob');
        $contributor->setLastname('Dylan');
        $contributor->setDepartment('Comptabilité');
        $contributor->setProfilePicture($faker->image(null, 640, 480));
        $contributor->setPosition('Directeur');
        $contributor->setWorkplace($this->getReference('office_lyon'));
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'contributorpassword'
        );

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);
*/
        $admin = new User();
        $admin->setEmail('superadmin@sf.com');
        $admin->setFirstname('Quentin');
        $admin->setLastname('Tarantino');
        $admin->setDepartment('Informatique');
        $admin->setProfilePicture($faker->image());
        $admin->setPosition('Assistant Manager');
        $admin->setWorkplace($this->getReference('office_lyon'));
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();

        $this->addReference('user_superadmin@sf.com', $admin);
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          OfficeFixtures::class,
        ];
    }
}
