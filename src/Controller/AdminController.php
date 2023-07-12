<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\IdeaRepository;
use App\Repository\ReportingRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/ideas', name: 'ideas')]
    public function ideas(IdeaRepository $ideaRepository, ReportingRepository $reportingRepository): Response
    {
        $ideas = $ideaRepository->findBy([], ['publicationDate' => 'DESC']);
        $reportedIdeas = $reportingRepository->findBy([], ['reportedIdea' => 'DESC']);
        return $this->render('admin/ideas.html.twig', [
            'ideas' => $ideas,
            'reportedIdeas' => $reportedIdeas
        ]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository,
        FileUploader $fileUploader
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $user->setPictureFileName($pictureFilename);
            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('admin_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
