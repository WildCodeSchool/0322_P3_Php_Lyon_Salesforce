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
    private EntityManagerInterface $entityManager;
    private Reader $csvReader;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
        $this->csvReader = Reader::createFromPath('assets\Import\user.csv');
    }

    protected function configure(): void
    {
        $this
            ->setName('app:import-data')
            ->setDescription('Import data from CSV file to database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->csvReader->setDelimiter(',');

        $records = $this->csvReader->getRecords();
        $importedUsersCount = 0;

        foreach ($records as $record) {
            $user = new User();
            $user->setFirstname($record[5]);
            $user->setLastname($record[6]);
            $user->setEmail($record[2]);
            $user->setRoles(explode(',', $record[3]));
            $user->setPassword($record[4]);
            $user->setDepartment($record[7]);
            $user->setPosition($record[8]);

            // Assuming you have a Workplace entity and you already know the Workplace_id
            $workplaceId = $record[1]; // Assuming the Workplace_id is in the eighth column of the CSV

            $workplace = $this->entityManager->getRepository(Office::class)->find($workplaceId);

            if (!$workplace) {
                throw new InvalidArgumentException('Workplace not found with ID: ' . $workplaceId);
            }

            $user->setWorkplace($workplace);

            $this->entityManager->persist($user);
            $importedUsersCount++;
        }

        $this->entityManager->flush();

        $output->writeln($importedUsersCount . ' users imported successfully.');

        return Command::SUCCESS;
    }
}
