<?php
require_once 'vendor/autoload.php';

define('CLIENT_ID', '539393218353-9ijkv9afncf9abj7jrjsu49d2j8a386o.apps.googleusercontent.com');
define('CLIENT_SECRET', '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');
define('REDIRECT_URI', 'http://localhost/Events/oauth2callback.php');
define('TOKEN_PATH', __DIR__ . '/token.json');

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Event Manager');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig([
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uris' => [REDIRECT_URI],
    ]);
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    if (file_exists(TOKEN_PATH)) {
        $accessToken = json_decode(file_get_contents(TOKEN_PATH), true);
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents(TOKEN_PATH, json_encode($client->getAccessToken()));
        }
    }

    return $client;
}
?>
