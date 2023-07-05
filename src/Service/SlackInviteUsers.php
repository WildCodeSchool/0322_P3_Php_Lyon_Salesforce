<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SlackInviteUsers
{
    public string $token;
    public HttpClientInterface $client;

    public function inviteUsersToChannel(string $channelId, string $slackId): array
    {
        $this->token = $_ENV['SLACK_OAUTH_TOKEN']; // Get the Slack OAuth token from the local environment variables
        $this->client = HttpClient::create([
            'base_uri' => 'https://slack.com/api/conversations.invite', // Set the base URI for the HTTP client
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token, // Set the authorization header with the OAuth token
                'Content-type' => 'application/json', // Set the content type header to JSON
            ],
        ]);
        $response = $this->client->request('POST', 'conversations.invite', [
            'body' => json_encode([
                'channel' => $channelId, // Set the channel name in the request body
                'users' => $slackId, // Get user slack ID
            ]),
        ]);

        return $this->handleResponse($response);
    }

    private function handleResponse(ResponseInterface $responseInterface): array
    {
        $statusCode = $responseInterface->getStatusCode(); // Get the HTTP status code from the response
        $content = $responseInterface->toArray(); // Convert the response content to an array

        if ($statusCode !== 200 || !$content['ok']) {
            throw new RuntimeException('Failed to invite to channel: ' . $content['error']);
            // If the status code is not 200 or the 'ok' property is false, throw an exception with the error message
        }

        return $content; // Return the response content as an array
    }
}
