<?php

namespace App\Service;

use App\Entity\Adherence;
use App\Entity\Idea;
use App\Entity\User;
use App\Repository\AdherenceRepository;

class AdhereToIdea
{
    public function __construct(private AdherenceRepository $adherenceRepository)
    {
    }

    public function adhereToIdea(User $user, Idea $idea): void
    {
        $adherence = new Adherence();
        $adherence->setAdherent($user);
        $adherence->setConcept($idea);
        $this->adherenceRepository->save($adherence, true);
    }
}
