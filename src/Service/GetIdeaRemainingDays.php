<?php

namespace App\Service;

use App\Entity\Idea;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetIdeaRemainingDays extends AbstractController
{
    public function getRemainingDays(Idea $idea): int
    {
        $endDate = $idea->getEndDate();
        $today = new DateTimeImmutable();
        $interval = $today->diff($endDate);
        $daysRemaining = $interval->days;

        return $daysRemaining;
    }
}
