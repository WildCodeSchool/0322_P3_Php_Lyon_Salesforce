<?php

namespace App\Service;

use App\Entity\Idea;

class IdeaSupporter
{
    public function supporterNeeded(Idea $idea): int
    {
        $perimeter = $idea->getPerimeter();

        if ($perimeter === 'Service') {
            $supporterNeeded = 3;
        } elseif ($perimeter === 'Agence') {
            $supporterNeeded = 8;
        } else {
            $supporterNeeded = 15;
        }

        return $supporterNeeded;
    }

    public function isChannelCreatable(int $totalSupporter, Idea $idea): bool
    {
        $supporterNeeded = $this->supporterNeeded($idea);
        if ($totalSupporter >= $supporterNeeded) {
            return true;
        } else {
            return false;
        }
    }
}
