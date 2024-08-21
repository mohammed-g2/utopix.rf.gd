<?php

namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Authentication;
use \Ninja\Controller;

class Users implements Controller
{
    private DatabaseTable $users;
    private Authentication $authentication;

    public function __construct(DatabaseTable $users, Authentication $authentication)
    {
        $this->users = $users;
        $this->authentication = $authentication;
    }

    public function __toString(): string
    {
        return '<Controller User>';
    }

    /**
     * method GET, return a list of users
     */
    public function list(): array
    {
        return [];
    }

    /**
     * method GET, get user by id
     */
    public function get(string $id): array
    {
        return [];
    }

    /**
     * method GET, return the registration form
     * method POST, attempt to create a new user account then redirect
     */
    public function create(): array|null
    {
        if ($this->authentication->isAuthenticated()) {
            header('location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($_POST['username'])) {
                $errors[] = 'invalid username';
            }
            if (empty($_POST['email'])) {
                $errors[] = 'invalid email';
            }
            if (empty($_POST['password'])) {
                $errors[] = 'invalid password';
            }
            if (!empty($this->users->filterBy(['username' => $_POST['username']]))) {
                $errors[] = 'please choose a different username';
            }
            if (!empty($this->users->filterBy(['email' => $_POST['email']]))) {
                $errors[] = 'please choose a different email';
            }

            if (empty($errors)) {
                $this->users->save([
                    'username' => $_POST['username'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'permissions' => 0
                ]);
                header('location: /auth/login');
                exit;
            }
            else {
                return [
                    'template' => 'auth/register.html.php',
                    'variables' => [
                        'errors' => $errors,
                        'username' => $_POST['username'],
                        'email' => $_POST['email']
                    ]
                ];
            }
        }
        return [
            'template' => 'auth/login.html.php'
        ];
    }

    /**
     * method GET, return the update user info form
     * method POST, attempt to update user info then redirect
     */
    public function update(string $id): array|null
    {
        return [];
    }

    /**
     * method POST, attempt to delete user account then redirect
     */
    public function delete(): void
    {
        return;
    }
}
