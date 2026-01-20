# GitHub User Activity (CLI) — PHP 8.2

A simple CLI tool that fetches and prints a GitHub user's recent public activity using the GitHub Events API.

- https://roadmap.sh/projects/github-user-activity

This project is built with **PHP 8.2** and **Guzzle**.

---

## Features

- Fetches recent public events for a given GitHub username
- Prints human-readable activity lines for common event types:
  - PushEvent
  - IssuesEvent
  - IssueCommentEvent
  - PullRequestEvent
  - WatchEvent
- Basic error handling (network errors, invalid user, API errors)
- Minimal structure: github-activity.php + GitHubClient

---

## Requirements

- PHP 8.2
- Composer

---

## Installation

1) Clone the repository:
```bash
git clone <your-repo-url>
cd github-user-activity
```

2) Install dependencies:
```bash
composer install
```

3) Generate autoload files (if needed):
```bash
composer dump-autoload
```

---

## Usage

Run the CLI tool by providing a GitHub username:

```bash
php github-activity.php <username>
```

Example:
```bash
php github-activity.php kamranahmedse
```

Sample output:
```text
- Starred Munawwar/voice-typing
- Commented on an issue in kamranahmedse/driver.js
- Closed an issue in kamranahmedse/driver.js      
- Pushed 0 commit(s) to kamranahmedse/timelang
```

---

## Project Structure

```text
.
├── github-activity.php
├── composer.json
├── composer.lock
└── src
    └── GitHubClient.php
```

---

## Notes

- This tool uses GitHub’s public events endpoint:
  GET https://api.github.com/users/<username>/events
- Authentication and rate-limit handling are intentionally omitted for simplicity.

---

