<?php
/**
 * Created by PhpStorm.
 * User: apandele
 * Date: 25/04/2016
 * Time: 17:25
 */

require __DIR__ . '/../src/config.php';

$provider = new League\OAuth2\Client\Provider\Facebook([
    // 'clientId'          => '{facebook-app-id}',
    'clientId' => '156427928091055',
    // 'clientSecret'      => '{facebook-app-secret}',
    'clientSecret' => '36e47177b16defcf6c6f7170e22594eb',
    // 'redirectUri'       => 'https://example.com/callback-url',
    'redirectUri' => 'http://localhost/DSI4EU/www/facebook.php',
    'graphApiVersion' => 'v2.6',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ['email'],
    ]);
    $_SESSION['oauth2state'] = $provider->getState();

    echo '<a href="' . $authUrl . '">Log in with Facebook!</a>';
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    //unset($_SESSION['oauth2state']);
    //echo 'Invalid state.';
    //exit;
}

// Try to get an access token (using the authorization code grant)
$token = $provider->getAccessToken('authorization_code', [
    'code' => $_GET['code']
]);

// Optional: Now you have a token you can look up a users profile data
try {

    // We got an access token, let's now get the user's details
    /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
    $user = $provider->getResourceOwner($token);

    # object(League\OAuth2\Client\Provider\FacebookUser)#10 (1) { ...

} catch (Exception $e) {

    // Failed to get user details
    exit('Oh dear...');
}