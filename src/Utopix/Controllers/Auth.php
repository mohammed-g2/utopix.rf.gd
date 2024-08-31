<?php

namespace Utopix\Controllers;

use \GuzzleHttp\Client as GuzzleClient;

use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Auth
{
    private DatabaseTable $users;
    private Authentication $authentication;

    public function __construct(DatabaseTable $users, Authentication $authentication)
    {
        $this->users = $users;
        $this->authentication = $authentication;
    }

    public function __toString()
    {
        return '<Controller Auth>';
    }

    public function login(array $environ)
    {        
        if ($this->authentication->isAuthenticated()) {
            header('location: /');
            exit;
        }

        if ($environ['SERVER']['REQUEST_METHOD'] === 'POST') {
            if ($this->authentication->login(
                    $environ['POST']['email'], $environ['POST']['password'])) {
                header('location: /');
                exit;
            }
            else {
                $errors = ['could not login, please choose a different username or password'];
                return [
                    'template' => 'auth/login.html.php',
                    'flashedMsgs' => $errors,
                    'variables' => [
                        'email' => $_POST['email']
                    ]
                ];
            }
        }
        else {
            return [
                'template' => 'auth/login.html.php'
            ];
        }
    }

    public function logout(array $environ)
    {
        if (!$this->authentication->isAuthenticated()) {
            header('location: /');
            exit;
        }

        $this->authentication->logout();
        header('location: /');
        exit;
    }

    public function authorizeDropbox(array $environ)
    {
        $authUrl = 'https://www.dropbox.com/oauth2/authorize?client_id=' 
                    . $environ['env']['DROPBOX_APP_KEY']
                    . '&redirect_uri='
                    . $environ['env']['DROPBOX_REDIRECT_URI']
                    . '&response_type=code&token_access_type=offline';
        header('Location: ' . $authUrl);
        exit;
    }

    public function saveDropboxToken(array $environ)
    { 
        $client = new GuzzleClient();
        $response = $client->request('POST', 'https://api.dropboxapi.com/oauth2/token',
            ['form_params' => [
                'code' => $environ['GET']['code'],
                'grant_type' => 'authorization_code',
                'client_id' => $environ['env']['DROPBOX_APP_KEY'], 
                'client_secret' => $environ['env']['DROPBOX_APP_SECRET'],
                'redirect_uri' => $environ['env']['DROPBOX_REDIRECT_URI']]]
        );
        $token = json_decode($response->getBody())->access_token;
        $file = fopen(__DIR__ . '/../../../token', 'w');
        fwrite($file, $token);
        fclose($file);
        header('Location: /posts/create');
        exit;
    }
}