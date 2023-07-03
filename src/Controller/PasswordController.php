<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Exception;


class PasswordController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    #[Route('/change-password', name: 'app_change_password')]
    public function changePassword(Request $request, UserRepository $userRepository): Response
    {
            /** @var User $user */
        $user = $this->getUser();

        // Create the password change form
        $form = $this->createForm(NewPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new password
            $userRepository->save($form, true);

            // Update the user's password and set firstLogin to false
            $user->setPassword($encodedPassword);
            $user->setFirstConnection(false);

            // Save the changes to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect the user after successfully changing the password
            return $this->redirectToRoute('app_homepage');
        }

        // Render the password change form
        return $this->render('login/passwordForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }





}
