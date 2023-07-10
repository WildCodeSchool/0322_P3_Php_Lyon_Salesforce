<?php

namespace App\Service;

use App\Entity\Idea;
use DateTimeImmutable;

class GetIdeaRemainingDays
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
