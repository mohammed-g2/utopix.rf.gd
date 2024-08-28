<?php

namespace Utopix\Controllers;

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

    public function login()
    {        
        if ($this->authentication->isAuthenticated()) {
            header('location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->authentication->login($_POST['email'], $_POST['password'])) {
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

    public function logout()
    {
        if (!$this->authentication->isAuthenticated()) {
            header('location: /');
            exit;
        }

        $this->authentication->logout();
        header('location: /');
        exit;
    }
}