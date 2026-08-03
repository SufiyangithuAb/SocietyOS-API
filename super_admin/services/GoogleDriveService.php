<?php

require_once __DIR__ . "/../vendor/autoload.php";

class GoogleDriveService
{
    private Google\Client $client;
    private Google\Service\Drive $drive;

    public function __construct()
    {
        $this->client = new Google\Client();

        $this->client->setApplicationName("SocietyOS Backup");

        $this->client->setScopes([
            Google\Service\Drive::DRIVE_FILE
        ]);

        $this->client->setAuthConfig(
            __DIR__ . "/../storage/credentials/google-drive.json"
        );

        $this->drive = new Google\Service\Drive($this->client);
    }

    public function upload($filePath, $fileName)
    {
        $fileMetadata = new Google\Service\Drive\DriveFile([
            'name' => $fileName,
            'parents' => [
                '1GaMs_zebc4rGoitZTivqQINSAE09fNVo'
            ]
        ]);

        $content = file_get_contents($filePath);

        $file = $this->drive->files->create(
            $fileMetadata,
            [
                'data' => $content,
                'mimeType' => 'application/sql',
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]
        );

        return $file->id;
    }
}