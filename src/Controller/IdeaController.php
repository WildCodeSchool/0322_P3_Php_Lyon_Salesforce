<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use App\Form\IdeaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/idea', name: 'idea_')]
class IdeaController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(Request $request, IdeaRepository $ideaRepository): Response
    {
        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->save($idea, true);

            $this->addFlash('success', 'Votre nouvelle idée a été partagé!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('idea/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{perimeterName}', name: 'show')]
    public function show(string $perimeterName, IdeaRepository $ideaRepository): Response
    {
        $perimeter = $ideaRepository->findOneBy(['perimeter' => $perimeterName]);

        $ideas = $ideaRepository->findby(
            ['perimeter' => $perimeterName],
            ['id' => 'DESC'],
        );


        return $this->render('idea/ideaByPerimeter.html.twig', [
            'perimeter' => $perimeter,
            'ideas' => $ideas,
         ]);
    }
}
