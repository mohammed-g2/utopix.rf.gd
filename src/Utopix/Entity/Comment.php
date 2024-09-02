<?php

namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class Comment
{
    public int $id;
    public string $body;
    public string $created_at;
    public int $user_id;
    public int $post_id;
    private DatabaseTable $users;
    private DatabaseTable $posts;

    public function __construct(DatabaseTable $users, DatabaseTable $posts)
    {
        $this->users = $users;
        $this->posts = $posts;
    }

    public function getUser(): object
    {
        return $this->users->getById($this->user_id);
    }

    public function getPost(): object
    {
        return $this->posts->getById($this->post_id);
    }
}