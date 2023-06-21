<?php

namespace App\Controller;

use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    #[Route('/ArchivesIdea/{idIdea}', name: 'archives_idea')]
    public function archivesIdea(int $idIdea, IdeaRepository $ideaRepository): Response
    {
        $idea = $ideaRepository->find($idIdea);
        $idea->setArchived(true);
        $ideaRepository->save($idea, true);


        return new Response(status: 200);
    }
}
