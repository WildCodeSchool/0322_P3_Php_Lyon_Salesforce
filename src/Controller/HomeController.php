<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/{page<\d+>}', name: 'app_home')]
    public function index(IdeaRepository $ideaRepository, int $page = 1): Response
    {
        $ideas = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new ArrayAdapter($ideaRepository->findBy(
                ['archived' => false],
                ['publicationDate' => 'DESC']
            )),
            $page,
            6
        );

        return $this->render('home/index.html.twig', [
            'ideas' => $ideas,
        ]);
    }
}
