<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
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
        FileUploader $fileUploader
    ): Response {
        $pictureFile = $request->files->get('user_picture');

        if ($pictureFile) {
            $pictureFilename = $fileUploader->upload($pictureFile);
            $user->setPictureFileName($pictureFilename);
        }
        $userRepository->save($user, true);

        return $this->render('user/profil.html.twig', [
            'user' => $user,
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
