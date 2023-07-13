<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AjaxController extends AbstractController
{
    #[Route('/ArchivesIdea/{idIdea}', name: 'archives_idea')]
    public function archivesIdea(int $idIdea, IdeaRepository $ideaRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $idea = $ideaRepository->find($idIdea);
            $idea->setArchived(true);
            $ideaRepository->save($idea, true);

            return new Response(status: 200);
        } elseif ($this->isGranted('ROLE_CONTRIBUTOR')) {

            /** @var User $user */
            $user = $this->getUser();
            $userId = $user->getId();

            $idea = $ideaRepository->findOneBy([
                'id' => $idIdea,
                'author' => $userId
            ]);

            if (is_null($idea)) {
                $this->addFlash('danger', 'Seul l\'auteur d\'une idée peut la supprimer');
                return $this->redirectToRoute('app_home');
            }

            $idea->setArchived(true);
            $ideaRepository->save($idea, true);

            return new Response(status: 200);
        }

        return new Response(status: 403);
    }
}
