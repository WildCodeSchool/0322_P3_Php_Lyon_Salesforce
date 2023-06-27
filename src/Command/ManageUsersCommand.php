<?php

namespace App\Command;

use App\Entity\Office;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-data')]
class ImportDataCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private Reader $csvReader;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->csvReader = Reader::createFromPath('assets\Import\data-I1oIuhWZh01D5tIN2mGsg.csv');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $filteredData = $this->filterFile();
        $newUsers = $filteredData['newUsers'];
        $formerUsers = $filteredData['formerUsers'];

        foreach ($newUsers as $user) {
            $workplaceName = $user['workplace'];

            // Check if the Office with the given location already exists
            $officeRepository = $this->entityManager->getRepository(Office::class);
            $office = $officeRepository->findOneBy(['location' => $workplaceName]);

            // If the Office doesn't exist, create a new one
            if (!$office) {
                $office = new Office();
                $office->setLocation($workplaceName);
                $this->entityManager->persist($office);
            }

            $email = $user['email'];

            // Check if the User with the given email already exists
            $userRepository = $this->entityManager->getRepository(User::class);
            $newUser = $userRepository->findOneBy(['email' => $email]);

            // If the User doesn't exist, create a new one
            if (!$newUser) {
                $newUser = new User();
                $newUser->setFirstName($user['firstName']);
                $newUser->setLastName($user['lastName']);
                //$newUser->setPhoneNumber($user['phoneNumber']);
                $newUser->setEmail($user['email']);
                $newUser->setDepartment($user['department']);
                $newUser->setWorkplace($office);

                $this->entityManager->persist($newUser);
            }
        }


        foreach ($formerUsers as $user) {
            $email = $user['email'];

            // Find the User exists, remove them from the database
            $userRepository = $this->entityManager->getRepository(User::class);
            $formerUser = $userRepository->findOneBy(['email' => $email]);

            if ($formerUser) {
                $this->entityManager->remove($formerUser);
            }
        }

        $this->entityManager->flush();

        $newUsersCount = count($newUsers);
        $formerUsersCount = count($formerUsers);
        $output->writeln("Successfully added $newUsersCount new users.");
        $output->writeln("Successfully deleted $formerUsersCount former users.");

        return Command::SUCCESS;
    }



    protected function filterFile(): array
    {
        $this->csvReader->setDelimiter(',');
        $this->csvReader->setHeaderOffset(1);

        $records = $this->csvReader->getRecords();

        $formerUsers = [];
        $newUsers = [];

        foreach ($records as $record) {
            $action = $record[0];

            $name = $record[1];
                $nameParts = explode(' ', $name);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1];

            $phoneNumber = $record[2];
            $email = $record[3];
            $department = $record[4];
            $workplace = $record[5];

            if ($action === 'Leave') {
                $formerUsers[] = [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phoneNumber' => $phoneNumber,
                    'email' => $email,
                    'department' => $department,
                    'workplace' => $workplace,
                ];
            } elseif ($action === 'Add') {
                $newUsers[] = [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phoneNumber' => $phoneNumber,
                    'email' => $email,
                    'department' => $department,
                    'workplace' => $workplace,
                ];
            }
        }
        return [
            'newUsers' => $newUsers,
            'formerUsers' => $formerUsers
        ];
    }
}
