<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class SlackService
{
    public $token;
    public $client;

    public function createChannel(string $channelName): array
    {
        $this->token = $_ENV['SLACK_OAUTH_TOKEN']; // Get the Slack OAuth token from the environment variables
        $this->client = HttpClient::create([
            'base_uri' => 'https://slack.com/api/conversations.create', // Set the base URI for the HTTP client
            'header' => [
                'Authorization' => 'Bearer' . $this->token, // Set the authorization header with the OAuth token
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
}
