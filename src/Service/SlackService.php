<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SlackService
{
    public string $token;
    public HttpClientInterface $client;

    public function createChannel(string $channelName): array
    {
        $this->token = $_ENV['SLACK_OAUTH_TOKEN']; // Get the Slack OAuth token from the local environment variables
        $this->client = HttpClient::create([
            'base_uri' => 'https://slack.com/api/conversations.create', // Set the base URI for the HTTP client
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token, // Set the authorization header with the OAuth token
                'Content-type' => 'application/json', // Set the content type header to JSON
            ],
        ]);
        $response = $this->client->request('POST', 'conversations.create', [
            'body' => json_encode([
                'name' => $channelName, // Set the channel name in the request body
            ]),
        ]);

        return $this->handleResponse($response); // Call the private handleResponse method to process the response
    }

    private function handleResponse(ResponseInterface $responseInterface): array
    {
        $statusCode = $responseInterface->getStatusCode(); // Get the HTTP status code from the response
        $content = $responseInterface->toArray(); // Convert the response content to an array

        if ($statusCode !== 200 || !$content['ok']) {
            throw new RuntimeException('Failed to create channel: ' . $content['error']);
            // If the status code is not 200 or the 'ok' property is false, throw an exception with the error message
        }

        return $content; // Return the response content as an array
    }

    // public function inviteUsers(SlackServiceInviteUsers $slackServiceInviteUsers): Response
    // {
    //     $channelId = 'channel_id';
    //     $slackId = ['slackId1', 'slackId2'];

    //     $response = $slackServiceInviteUsers->inviteUsersToChannel();
    //     // Call the inviteUsersToChannel method of SlackServiceInviteUsers

    //     if ($response['ok']) {
    //         $message = 'Les utilisateurs ont bien été invités sur le canal slack.'; // Success message created
    //     } else {
    //         $error = $response['error'];
    //         $message = 'Les utilisateurs n\'ont pas été invités sur le canal: {$error}.';
    //         // Create an error message with the error details
    //     }

    //     return Response;
    // }
}
