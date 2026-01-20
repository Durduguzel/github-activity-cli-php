<?php

require __DIR__ . '/vendor/autoload.php';

use App\GitHubClient;

$args = $argv;
array_shift($args);

if (count($args) === 0) {
    echo "Usage: php github-activity.php <username>\n";
    exit(1);
}

$username = $args[0] ?? null;

if ($username === null || trim($username) === '') {
    echo "Usage: php github-activity.php <username>\n";
    exit(1);
}

try {
    $client = new GitHubClient();
    $events = $client->getUserEvents($username);
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

if (count($events) === 0) {
    echo "No activity found.\n";
    exit(0);
}

foreach ($events as $event) {
    $type = (string)($event['type'] ?? 'UnknownEvent');
    $repo = (string)($event['repo']['name'] ?? 'unknown/repo');
    $payload = is_array($event['payload'] ?? null) ? $event['payload'] : [];

    switch ($type) {
        case 'PushEvent':
            $commits = is_array($payload['commits'] ?? null) ? $payload['commits'] : [];
            $count = count($commits);
            echo "- Pushed {$count} commit(s) to {$repo}\n";
            break;

        case 'IssuesEvent':
            $action = (string)($payload['action'] ?? 'acted on');
            echo "- " . ucfirst($action) . " an issue in {$repo}\n";
            break;

        case 'IssueCommentEvent':
            echo "- Commented on an issue in {$repo}\n";
            break;

        case 'PullRequestEvent':
            $action = (string)($payload['action'] ?? 'acted on');
            echo "- " . ucfirst($action) . " a pull request in {$repo}\n";
            break;

        case 'WatchEvent':
            echo "- Starred {$repo}\n";
            break;

        default:
            echo "- Did {$type} in {$repo}\n";
            break;
    }
}
