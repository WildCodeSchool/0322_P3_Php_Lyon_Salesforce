<?php

namespace App\Controller;

use App\Entity\Adherence;
use App\Entity\Idea;
use App\Entity\User;
use App\Form\IdeaType;
use App\Repository\AdherenceRepository;
use App\Repository\IdeaRepository;
use App\Service\AdhereToIdea;
use App\Service\IdeaFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/idea', name: 'idea')]
class IdeaController extends AbstractController
{
    #[Route('/new', name: '_new')]
    public function new(Request $request, IdeaRepository $ideaRepository, IdeaFormHandler $ideaFormHandler): Response
    {

        $result = $ideaFormHandler->formHandler();
        $form = $result['form'];
        $idea = $result['idea'];

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

    #[Route('/{id}/edit', name: '_edit')]
    public function edit(
        Request $request,
        Idea $idea,
        IdeaRepository $ideaRepository,
    ): Response {
        if ($this->getUser() !== $idea->getAuthor()) {
            $this->addFlash('danger', 'Seul l\'auteur d\'une idée peut la modifier');
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->save($idea, true);

            $this->addFlash('success', 'Votre idée a été modifié!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('idea/edit.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }


    #[Route('/MyOffice', name: 's_by_user_office')]
    public function showOffice(IdeaRepository $ideaRepository): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        $officeId = $user->getWorkplace()->getId();

        $ideas = $ideaRepository->getIdeasByUserOffice($officeId);

        return $this->render('idea/ideasByUserOffice.html.twig', [
            'user' => $user,
            'ideas' => $ideas,

        ]);
    }

    #[Route('/MyDepartment', name: 's_by_user_department')]
    public function showDepartment(IdeaRepository $ideaRepository): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        $officeId = $user->getWorkplace()->getId();
        $departmentName = $user->getDepartment();

        $ideas = $ideaRepository->getIdeasByUserDepartment($officeId, $departmentName);

        return $this->render('idea/ideasByUserDepartment.html.twig', [
            'user' => $user,
            'ideas' => $ideas,

        ]);
    }

    #[Route('/{id}', name: '_show')]
    public function show(
        Idea $idea,
        Request $request,
        AdherenceRepository $adherenceRepository,
        AdhereToIdea $adhereToIdea
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        if (!empty($adherenceRepository->getUserAdherence($idea->getId(), $user->getId()))) {
            $isAdhere = true;
        } else {
            $isAdhere = false;
        }

        if ($request->get('adherence') && $isAdhere === false) {
            $adhereToIdea->adhereToIdea($user, $idea);
            $this->addFlash('success', 'vous avez bien adhérer à cette idée');
            return $this->redirectToRoute('idea_show', ['id' => $idea->getId()]);
        }

        return $this->render('idea/show.html.twig', [
            'idea' => $idea,
            'numberOfAdherence' => $adherenceRepository->getNumberOfAdherence($idea->getId()),
            'isAdhere' => $isAdhere,
        ]);
    }
}
