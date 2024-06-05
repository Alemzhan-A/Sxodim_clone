<?php
require_once 'config.php';

session_start();

$client = getClient();

if (!isset($_GET['code'])) {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit();
} else {
    // Exchange authorization code for an access token.
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (array_key_exists('error', $token)) {
        throw new Exception(join(', ', $token));
    }

    // Store the token to a file.
    if (!file_exists(dirname(TOKEN_PATH))) {
        mkdir(dirname(TOKEN_PATH), 0700, true);
    }
    file_put_contents(TOKEN_PATH, json_encode($client->getAccessToken()));

    // Redirect to profile page
    header('Location: profile.php');
    exit();
}
?>
