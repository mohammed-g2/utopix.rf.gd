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

    }

    public function logout()
    {
        
    }
}