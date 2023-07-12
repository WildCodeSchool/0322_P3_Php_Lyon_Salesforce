<?php

// namespace App\Service;

// use App\Entity\Reporting;
// use App\Entity\Idea;
// use App\Entity\User;
// use App\Form\ReportingType;
// use DateTimeImmutable;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// class ReportingHandler extends AbstractController
// {
//     public function formHandler(): array
//     {

//         /** @var User $user */
//         $user = $this->getUser();
//         $date = new DateTimeImmutable();
//         $publicationDate = $date->setDate(intval(date('Y')), intval(date('m')), intval(date('d')));

//         $reporting = new Reporting();

//         // $idea->setPublicationDate($publicationDate);
//         // $idea->setEndDate($endDate);
//         // $idea->setArchived(false);
//         // $idea->setAuthor($user);

//         return [
//         'form' => $form,
//         ];
//     }
// }
