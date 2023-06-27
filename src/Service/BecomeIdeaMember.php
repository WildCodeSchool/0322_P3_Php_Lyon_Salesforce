<?php

namespace App\Service;

use App\Entity\Membership;
use App\Entity\Idea;
use App\Entity\User;
use App\Repository\MembershipRepository;

class BecomeIdeaMember
{
    public function __construct(private MembershipRepository $membershipRepository)
    {
    }

    public function becomeIdeaMember(User $user, Idea $idea): void
    {
        $membership = new Membership();
        $membership->setMember($user);
        $membership->setConcept($idea);
        $this->membershipRepository->save($membership, true);
    }
}
