<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IdeaController extends AbstractController
{
    #[Route('/idea', name: 'new_idea')]
    public function index(Request $request, IdeaRepository $ideaRepository): Response
    {
        $idea = new Idea(); 

        // Create the form linked with $idea :
        $form = $this->createForm(IdeaType::class, $idea);
        // Get the data from HTTP request :
        $form->handleRequest($request);
        // Form submitted ? 
        if ($form->isSubmitted()) {
            $ideaRepository->save($idea, true);
            return $this->redirectToRoute('idea_index');
        }

        return $this->render('idea/index.html.twig', [
            'controller_name' => 'IdeaController',
        ]);
    }
}
