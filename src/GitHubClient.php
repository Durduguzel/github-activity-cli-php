<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GitHubClient
{
    private Client $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => 'https://api.github.com/',
            'timeout' => 10.0,
            'headers' => [
                'User-Agent' => 'github-user-activity-cli',
                'Accept' => 'application/vnd.github+json',
            ],
        ]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUserEvents(string $username): array
    {
        try {
            $response = $this->http->get("users/{$username}/events", [
                'http_errors' => false,
            ]);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Request failed: ' . $e->getMessage());
        }

        $status = $response->getStatusCode();

        if ($status === 404) {
            throw new \RuntimeException("User not found: {$username}");
        }

        if ($status < 200 || $status >= 300) {
            throw new \RuntimeException("GitHub API error: HTTP {$status}");
        }

        $body = (string) $response->getBody();

        try {
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Invalid JSON response from GitHub.');
        }

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }
}
