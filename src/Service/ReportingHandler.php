<?php

namespace App\Service;

use App\Entity\Idea;
use App\Entity\Reporting;
use App\Entity\User;
use App\Repository\ReportingRepository;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportingHandler extends AbstractController
{
    private ReportingRepository $reportingRepository;

    public function __construct(ReportingRepository $reportingRepository)
    {
        $this->reportingRepository = $reportingRepository;
    }
    public function handleReport(Request $request, Idea $idea, User $user): void
    {
        $existingReport = $this->reportingRepository->findIfAlreadyReported($idea->getId(), $user->getId());
        if (!empty($existingReport)) {
            $this->addFlash('danger', "Vous avez déjà signalé cette idée auparavant.");
            return;
        } elseif ($user->getId() !== $idea->getAuthor()->getId()) {
            $motive = $request->get('motive');
            $date = new DateTimeImmutable();
            $publicationDate = $date->setDate(intval(date('Y')), intval(date('m')), intval(date('d')));
            $reporting = new Reporting();
            $reporting->setReportedIdea($idea);
            $reporting->setReportingUser($user);
            $reporting->setReportDate($publicationDate);
            $reporting->setMotive($motive);
            $this->reportingRepository->save($reporting, true);

            $this->addFlash('success', "L'idée a bien été signalée");
        } else {
            $this->addFlash('danger', "Une erreur s'est produite lors du signalement de l'idée.");
        }
    }
}
