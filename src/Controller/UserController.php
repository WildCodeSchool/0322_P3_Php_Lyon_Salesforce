<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\IdeaRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use App\Service\ImageVerification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(
        User $user,
        Request $request,
        UserRepository $userRepository,
        IdeaRepository $ideaRepository,
        FileUploader $fileUploader,
        ImageVerification $imageVerification
    ): Response {

        $userId = $user->getId();
        $ideas = $ideaRepository->getActiveUserIdeas($userId);
        $pictureFile = $request->files->get('upload-user-picture');

        if (!empty($pictureFile)) {
            if (!$imageVerification->imageVerification($pictureFile)) {
                $this->addFlash('danger', 'Veuillez utilisez une image au Format PNG, JPG ou JPEG');
            } else {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $user->setPictureFileName($pictureFilename);
                $userRepository->save($user, true);
            }
        }

        $supportingIdeas = $user->getSupportingIdeas();

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'ideas' => $ideas,
            'supportingIdeas' => $supportingIdeas
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('admin_users', [], Response::HTTP_SEE_OTHER);
    }
}
