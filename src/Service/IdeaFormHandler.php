<?php

namespace App\Service;

use App\Entity\Idea;
use App\Entity\User;
use App\Form\IdeaType;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdeaFormHandler extends AbstractController
{
    public function formHandler(): array
    {

        /** @var User $user */
        $user = $this->getUser();
        $date = new DateTimeImmutable();
        $publicationDate = $date->setDate(intval(date('Y')), intval(date('m')), intval(date('d')));
        $endDate = $publicationDate->modify('+31 days');

        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);

        $idea->setPublicationDate($publicationDate);
        $idea->setEndDate($endDate);
        $idea->setArchived(false);
        $idea->setAuthor($user);

        return [
        'form' => $form,
        'idea' => $idea
        ];
    }
}
