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
    public function list(array $environ): array
    {
        return [];
    }

    /**
     * method GET, get user by id
     */
    public function get(array $environ, string $id): array
    {
        return [];
    }

    /**
     * method GET, return the registration form
     * method POST, attempt to create a new user account then redirect
     */
    public function create(array $environ): array|null
    {
        if ($this->authentication->isAuthenticated()) {
            header('location: /');
        }

        if ($environ['SERVER']['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            if (empty($environ['POST']['username'])) {
                $errors[] = 'invalid username';
            }
            if (strlen($environ['POST']['username']) < 3) {
                $errors[] = 'username cannot be less than 3 characters';
            }
            if (empty($environ['POST']['email'])) {
                $errors[] = 'invalid email';
            }
            if (empty($environ['POST']['password'])) {
                $errors[] = 'invalid password';
            }
            if (strlen($environ['POST']['password']) < 6) {
                $errors[] = 'password cannot be less than 6 characters';
            }
            if (!empty($this->users->filterBy(['username' => $environ['POST']['username']]))) {
                $errors[] = 'please choose a different username';
            }
            if (!empty($this->users->filterBy(['email' => $environ['POST']['email']]))) {
                $errors[] = 'please choose a different email';
            }

            if (empty($errors)) {
                if ($environ['POST']['username'] === $environ['env']['ADMIN_USERNAME'] 
                        && $environ['POST']['email'] === $environ['env']['ADMIN_EMAIL']) {
                    $this->users->save([
                        'username' => $environ['POST']['username'],
                        'email' => $environ['POST']['email'],
                        'password' => password_hash($environ['POST']['password'], PASSWORD_DEFAULT),
                        'permissions' => \Utopix\Entity\User::adminPermissions()
                    ]);
                }
                else {
                    $this->users->save([
                        'username' => $environ['POST']['username'],
                        'email' => $environ['POST']['email'],
                        'password' => password_hash($environ['POST']['password'], PASSWORD_DEFAULT),
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
                        'username' => $environ['POST']['username'],
                        'email' => $environ['POST']['email']
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
    public function update(array $environ, string $id): array|null
    {
        return [];
    }

    /**
     * method POST, attempt to delete user account then redirect
     */
    public function delete(array $environ): void
    {
        return;
    }
}
