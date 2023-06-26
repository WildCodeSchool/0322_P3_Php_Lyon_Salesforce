<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(IdeaRepository $ideaRepository): Response
    {
        $ideas = $ideaRepository->findBy(
            ['archived' => false],
            ['publicationDate' => 'DESC']
        );

        return $this->render('home/index.html.twig', [
            'ideas' => $ideas,
        ]);
    }
}
