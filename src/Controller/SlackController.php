<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\MembershipRepository;
use App\Service\SlackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_USER')]
class SlackController extends AbstractController
{
    #[Route('/slack', name: 'app_slack')]
    public function index(): Response
    {
        return $this->render('slack/index.html.twig', [
            'controller_name' => 'SlackController',
        ]);
    }

    #[Route('{id}/createchannel', name: 'create_channel')]
    public function createChannel(
        SlackService $slackService,
        Idea $title,
        SluggerInterface $slugger,
        Idea $idea,
        MembershipRepository $membershipRepository
    ): Response {
        $channelName = $title->getTitle(); // Set the channel name based on idea name

        $slug = $slugger->slug($channelName, '_'); // Apply the slugger to the channel name

        $channel = $slackService->createChannel($slug);
        // Call the createChannel method of SlackService with the specified channel name with slug

        if ($channel['ok']) {
            $channelId = $channel['channel']['id']; // Extract the channel ID from the response

            $slackService->inviteUsers($channelId);
            $this->addFlash('success', "Nouveau canal Slack créé : {$channelName} (ID: {$channelId}).");
            // Create a success message with the channel name and ID
        } else {
            $error = $channel['error']; // Extract the error message from the response
            $this->addFlash('error', "Echec de création du canal Slack : {$error}.");
            // Create an error message with the error's name
        }

        /** @var User $user */
        $user = $this->getUser();

        if (
            !empty($membershipRepository->getIfUserIsIdeaMember($idea->getId(), $user->getId()))
        ) {
            $isMember = true;
        } else {
            $isMember = false;
        }

        return $this->render('idea/show.html.twig', [
            'idea' => $idea,
            'numberOfMembership' => $membershipRepository->getNumberOfMembership($idea->getId()),
            'isMember' => $isMember,
        ]);// Show the flash message to the 'idea/show.html.twig' template
    }
}
