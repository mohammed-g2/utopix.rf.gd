<?php

namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Controller;

class Users implements Controller
{
    private DatabaseTable $users;

    public function __construct(DatabaseTable $users)
    {
        $this->users = $users;
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
        return [];
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
