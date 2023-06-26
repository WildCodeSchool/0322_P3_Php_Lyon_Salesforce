<?php

namespace App\Command;

use App\Entity\Office;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Command("app:import-data")
 * @Description("Import data from CSV file to database")
 */

class ImportDataCommand extends Command
{
    //private EntityManagerInterface $entityManager;
    private Reader $csvReader;

    public function __construct(/*EntityManagerInterface $entityManager*/)
    {
        parent::__construct();

        //$this->entityManager = $entityManager;
        $this->csvReader = Reader::createFromPath('assets\Import\data-I1oIuhWZh01D5tIN2mGsg.csv');
    }

    protected function configure(): void
    {
        $this
            ->setName('app:import-data')
            ->setDescription('Import data from CSV file to database');
    }

    protected function filterFile(InputInterface $input, OutputInterface $output): array
    {
        $this->csvReader->setDelimiter(',');
        $this->csvReader->setHeaderOffset(1);

        $records = $this->csvReader->getRecords();
        //$importedUsersCount = 0;

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
