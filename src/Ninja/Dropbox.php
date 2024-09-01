<?php

namespace Ninja;

use Exception;
use \Spatie\Dropbox\Client as DropboxClient;

class Dropbox
{
    private DropboxClient $client;
    private ?string $token;

    public function __construct()
    {
        $this->token = null;
        $this->loadToken();
        $this->client = new DropboxClient($this->token);
    }

    /**
     * load token from saved file if it exists else redirect to oauth2 authentication page
     */
    private function loadToken()
    {
        if ($this->token === null) {
            $file = __DIR__ . '/../../token';
            if (file_exists($file)) {
                $this->token = file_get_contents($file);
            }
            else {
                header('Location: /auth/dropbox');
                exit;
            }
        }
    }

    /**
     * upload image to dropbox
     * if successful returns [
     *      'path' => 'image path on dropbox',
     *      'link' => 'the image link'
     * ]
     * else returns [
     *      'error' => true,
     *      'errors' => []
     * ]
     * 
     * @param array $file - $_FILE['name']
     * @param bool $ignore_empty - if set to true returns an empty list if 
     *             no image provided instead of an error
     */
    public function uploadImage(array $file, bool $ignore_empty=false): array
    {
        $errors = [];
        
        if ($ignore_empty && empty($file['tmp_name'])) {
            return [];
        }

        if (empty($file['tmp_name'])) {
            $errors[] = 'you did not choose an image';
        } else {
            if (getimagesize($file['tmp_name']) === false) {
                $errors[] = 'file is not an image';
            }
        }
        if ($file['size'] > 1024 * 1024) {
            $errors[] = 'image is larger than 1 MB';
        }
        $imageFileType = strtolower(
            pathinfo(basename($file['name']), PATHINFO_EXTENSION)
        );
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

        if (!in_array($imageFileType, $allowedExtensions)) {
            $errors[] = 'file extension not allowed';
        }

        if (!empty($errors)) {
            return [
                'error' => true,
                'errors' => $errors
            ];
        } else {
            try {
                $path = '/images/' . rand() . '-' . $file['name'];
                $img = fopen($file['tmp_name'], 'r');
                $res = $this->client->upload($path, $img, 'add');

                return [
                    'path' => $path,
                    'link' => $this->client->createSharedLinkWithSettings($path)['url'] . '&raw=1'
                ];
            } catch (\Exception $e) {
                if (empty($e->getMessage()) || stristr($e->getMessage(), '401 Unauthorized')) {
                    header('Location: /auth/dropbox');
                    exit;
                }
                return [
                    'errors' => [
                        'could not upload image to dropbox, Error: ' . $e->getMessage()]
                ];
            }
        }
    }

    /**
     * Delete a file from dropbox account
     */
    public function delete(string $path)
    {
        try {
            $this->client->delete($path);
        }
        catch (\Exception $e) {}
    }

    /**
     * return true if current token is valid else starts authorization flow
     */
    public function checkAuthorized(): ?bool
    {
        try {
            $this->client->getAccountInfo();
            return true;
        }
        catch (Exception $e) {
            header('Location: /auth/dropbox');
            exit;
        }
    }
}
