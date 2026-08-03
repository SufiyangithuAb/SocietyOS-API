<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../google/GoogleOAuthService.php";

class GoogleDriveService
{
    private Google\Client $client;
    private Google\Service\Drive $drive;

    public function __construct()
    {
        $db = (new Database())->connect();

        $google = new GoogleOAuthService();

        $this->client = $google->getClient();

        $refreshToken = $db
            ->query("SELECT refresh_token FROM google_tokens LIMIT 1")
            ->fetchColumn();

        if (!$refreshToken) {
            throw new Exception("Google Drive not connected.");
        }

        $this->client->fetchAccessTokenWithRefreshToken($refreshToken);

        $this->drive = new Google\Service\Drive($this->client);
    }

    public function upload($filePath, $fileName)
    {
        $metadata = new Google\Service\Drive\DriveFile([
            'name' => $fileName
        ]);

        $file = $this->drive->files->create(
            $metadata,
            [
                'data' => file_get_contents($filePath),
                'mimeType' => 'application/sql',
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]
        );

        return $file->id;
    }
}