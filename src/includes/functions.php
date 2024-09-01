<?php

use \Spatie\Dropbox\Client;

/**
 * pretty echo, for debugging
 */
function p_echo($var) {
    echo
    highlight_string('<?php ' . var_export($var, true) . '?>') 
    . '<br>';
}

/**
 * $file is $_FILES['name'],
 * attempt to upload image and return either an 
 * array of errors or the image name
 * @param array $file - $_FILE['name']
 * @param bool $ignore_empty - returns an empty list if no image provided instead of an error
 */
function upload_image(array $file, bool $ignore_empty=false): array {
    $errors = [];

    if ($ignore_empty && empty($file['tmp_name'])) {
        return [];
    }
    if (empty($file['tmp_name'])) {
        $errors[] = 'you did not choose an image';
    }
    else {
        if (getimagesize($file['tmp_name']) === false) {
            $errors[] = 'file is not an image';
        }
    }
    if ($file['size'] > 1024 * 1024) {
        $errors[] = 'image is larger than 1 MB';
    }

    $imageFileType = strtolower(
        pathinfo(basename($file['name']), PATHINFO_EXTENSION));
    $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

    if (!in_array($imageFileType, $allowedExtensions)) {
        $errors[] = 'file extension not allowed';
    }

    if (!empty($errors)) {
        return $errors;
    }
    else {
        $imgName = rand() . '-' . $_FILES['img']['name'];
        $saveFolder = __DIR__ . '/../public/assets/images/' . $imgName;
        move_uploaded_file($_FILES['img']['tmp_name'], $saveFolder);
        return ['url' => $imgName];
    }
}