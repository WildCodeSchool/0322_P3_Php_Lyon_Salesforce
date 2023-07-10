<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Entity\Idea;
use DateTime;

#[AsCommand(name: 'app:archive-ideas')]
class ArchiveIdeasCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentDate = new DateTime();

        $repository = $this->entityManager->getRepository(Idea::class);
        $ideas = $repository->findAll();

        foreach ($ideas as $idea) {
            $endDate = $idea->getEndDate();

            if ($endDate->format('Y-m-d') <= $currentDate->format('Y-m-d')) {
                $idea->setArchived(true);
            }
        }

        $this->entityManager->flush();

        $output->writeln('Ideas with endDate matching the current date have been archived.');

        return Command::SUCCESS;
    }
}
