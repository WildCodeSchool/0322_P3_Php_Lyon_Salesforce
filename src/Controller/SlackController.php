<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Service\SlackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SlackController extends AbstractController
{
    #[Route('/slack', name: 'app_slack')]
    public function index(): Response
    {
        return $this->render('slack/index.html.twig', [
            'controller_name' => 'SlackController',
        ]);
    }

    #[Route('/createchannel/{title}', name: 'create_channel')]
    public function createChannel(SlackService $slackService, Idea $ideaTitle): Response
    {
        $channelName = $ideaTitle->getTitle(); // Set the channel name based on idea name

        $channel = $slackService->createChannel($channelName);
        // Call the createChannel method of SlackService with the specified channel name

        if ($channel['ok']) {
            $channelId = $channel['channel']['id']; // Extract the channel ID from the response
            $message = "New channel created: {$channelName} (ID: {$channelId}).";
            // Create a success message with the channel name and ID
        } else {
            $error = $channel['error']; // Extract the error message from the response
            $message = "Failed to create channel: {$error}."; // Create an error message with the error details
        }

        return $this->render('slack/create_channel.html.twig', [
            'message' => $message, // Pass the message to the 'slack/create_channel.html.twig' template
        ]);
    }
}
