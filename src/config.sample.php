<?php

define('SITE_DOMAIN', '{domainName}');
define('SITE_RELATIVE_PATH', '{relativePath}');

if (!defined('NO_SESSION') OR NO_SESSION != true) {
    session_set_cookie_params(
        $lifetime = 0,
        $path = SITE_RELATIVE_PATH . '/',
        $domain = "",
        $secure = true,
        $httponly = true
    );
    session_start();
}

require __DIR__ . '/functions.php';
require __DIR__ . '/exceptions.php';
require __DIR__ . '/../vendor/autoload.php';

\DSI\Repository\OrganisationRepositoryInAPC::setApcKey(
    'digitalSocial:organisations'
);
\DSI\Repository\ProjectRepositoryInAPC::setApcKey(
    'digitalSocial:projects'
);

\DSI\Service\SQL::credentials(array(
    'username' => '',
    'password' => '',
    'db' => '',
));

\DSI\Service\FacebookLogin::setCredentials([
    'clientId' => '{facebook-app-id}',
    'clientSecret' => '{facebook-app-secret}',
    'redirectUri' => '{https://example.com}/facebook-login',
    'graphApiVersion' => 'v2.6',
]);

\DSI\Service\GitHubLogin::setCredentials([
    'clientId' => '{github-client-id}',
    'clientSecret' => '{github-client-secret}',
    'redirectUri' => '{http://example.com}/github-login',
]);

\DSI\Service\GoogleLogin::setCredentials([
    'clientId' => '{google-app-id}',
    'clientSecret' => '{google-app-secret}',
    'redirectUri' => '{http://example.com}/google-login',
    'hostedDomain' => '{http://example/com}',
]);

\DSI\Service\TwitterLogin::setCredentials([
    'identifier' => '{your-identifier}',
    'secret' => '{your-secret}',
    'callback_uri' => "{http://example.com}/twitter-login",
]);
