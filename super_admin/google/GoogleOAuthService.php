<?php

require_once __DIR__ . "/../vendor/autoload.php";

class GoogleOAuthService
{
    private Google\Client $client;

    public function __construct()
    {
        $config = require __DIR__ . "/../config/google.php";

        $this->client = new Google\Client();

        $this->client->setApplicationName("SocietyOS");

        $this->client->setClientId($config['client_id']);

        $this->client->setClientSecret($config['client_secret']);

        $this->client->setRedirectUri($config['redirect_uri']);

        $this->client->setScopes([
            Google\Service\Drive::DRIVE
        ]);

        // Required to obtain a refresh token
        $this->client->setAccessType("offline");

        // Always ask for consent the first time
        $this->client->setPrompt("consent");
    }

    /**
     * Get Google Login URL
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Exchange authorization code for access token
     */
    public function fetchAccessToken($code)
    {
        return $this->client->fetchAccessTokenWithAuthCode($code);
    }

    /**
     * Set existing access token
     */
    public function setAccessToken($token)
    {
        $this->client->setAccessToken($token);
    }

    /**
     * Refresh expired token
     */
    public function refreshToken($refreshToken)
    {
        $this->client->fetchAccessTokenWithRefreshToken($refreshToken);

        return $this->client->getAccessToken();
    }

    /**
     * Get Google Client
     */
    public function getClient()
    {
        return $this->client;
    }
}