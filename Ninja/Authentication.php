<?php

namespace Ninja;

use \Ninja\DatabaseTable;

/**
 * user authentication, creates a new session
 * @method bool login(string $username, string $password) login user using username and password
 * @method bool isLoggedIn() check if user is logged in
 * @method void logout() logout user
 */
class Authentication {
    private DatabaseTable $users;
    private string $usernameColumn;
    private string $passwordColumn;

    /**
     * 
     * @param \Ninja\DatabaseTable $users - the users table
     * @param string $usernameColumn - the username database column name to use in authentication
     * @param string $passwordColumn - the password database column name to use in authentication
     */
    public function __construct(DatabaseTable $users, string $usernameColumn, string $passwordColumn)
    {
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
        session_start();
    }

    public function __toString(): string
    {
        return '<Class Authentication>';
    }

    /**
     * login user using username and password, return true and create
     * a new session if succeeded, else false
     */
    public function login(string $username, string $password): bool {
        $user = $this->users->filterBy([$this->usernameColumn => strtolower($username)]);
        $passwordCol = $this->passwordColumn;
        if (!empty($user) && password_verify($password, $user[0]->$passwordCol)) {
            session_regenerate_id();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user[0]->$passwordCol;
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * check if current user is logged in
     */
    public function isAuthenticated(): bool {
        if (empty($_SESSION['username'])) {
            return false;
        }
        
        $user = $this->users->filterBy([$this->usernameColumn => strtolower($_SESSION['username'])]);
        $passwordCol = $this->passwordColumn;

        if (!empty($user) && $user[0]->$passwordCol === $_SESSION['password']) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * get current logged in user, else return false
     */
    public function getCurrentUer(): object|bool {
        if ($this->isAuthenticated()) {
            return $this->users->filterBy(
                [$this->usernameColumn => strtolower($_SESSION['username'])])[0];
        }
        else {
            return false;
        }
    }

    /**
     * logout user, remove session
     */
    public function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        session_regenerate_id();
    }
}