<?php

namespace App\Controller;

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

    #[Route('/createchannel', name: 'create_channel')]
    public function createChannel(SlackService $slackService): Response
    {
        $channelName = 'testcreatechannel'; // Set the channel name to 'channelname' (replace with desired channel name)
        // Put in slug cf doc symfony -> automatically create a channel from an idea
        $channel = $slackService->createChannel($channelName); 
        // Call the createChannel method of SlackService with the specified channel name
    }
}
