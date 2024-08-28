<?php

namespace Ninja;

use \Spatie\Dropbox\Client;

class Dropbox
{
    private Client $client;

    public function __construct(string $token)
    {
        $this->client = new Client($token);
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
     */
    public function uploadImage(array $file): array
    {
        $errors = [];

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
                return [
                    'error' => true,
                    'errors' => ['could not upload image to dropbox']
                ];
            }
        }
    }

    /**
     * Delete a file from dropbox account
     */
    public function delete(string $path)
    {
        $this->client->delete($path);
    }
}
