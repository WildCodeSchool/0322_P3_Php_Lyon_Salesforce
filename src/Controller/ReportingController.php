<?php

namespace App\Controller;


use App\Entity\Reporting;
use App\Form\ReportingType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_USER')]
class ReportingController extends AbstractController
{
    #[Route('/reporting', name: 'reporting_idea')]
    public function new(): Response
    {
        $reporting = new Reporting();

        $form = $this->createForm(ReportingType::class, $reporting);
        

        return $this->render('reporting/reportingForm.html.twig', [
            'form' => $form,
        ]);
    }
}