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
            if (strlen($_POST['username']) < 3) {
                $errors[] = 'username cannot be less than 3 characters';
            }
            if (empty($_POST['email'])) {
                $errors[] = 'invalid email';
            }
            if (empty($_POST['password'])) {
                $errors[] = 'invalid password';
            }
            if (strlen($_POST['password']) < 6) {
                $errors[] = 'password cannot be less than 6 characters';
            }
            if (!empty($this->users->filterBy(['username' => $_POST['username']]))) {
                $errors[] = 'please choose a different username';
            }
            if (!empty($this->users->filterBy(['email' => $_POST['email']]))) {
                $errors[] = 'please choose a different email';
            }

            if (empty($errors)) {
                $env = parse_ini_file(__DIR__ . '/../../.env');
                if ($_POST['username'] === $env['ADMIN_USERNAME'] && $_POST['email'] === $env['ADMIN_EMAIL']) {
                    $this->users->save([
                        'username' => $_POST['username'],
                        'email' => $_POST['email'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'permissions' => \Utopix\Entity\User::adminPermissions()
                    ]);
                }
                else {
                    $this->users->save([
                        'username' => $_POST['username'],
                        'email' => $_POST['email'],
                        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                        'permissions' => 0
                    ]);
                }
                header('location: /auth/login');
                exit;
            }
            else {
                return [
                    'template' => 'users/register.html.php',
                    'flashedMsgs' => $errors,
                    'variables' => [
                        'username' => $_POST['username'],
                        'email' => $_POST['email']
                    ]
                ];
            }
        }
        return [
            'template' => 'users/register.html.php'
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
