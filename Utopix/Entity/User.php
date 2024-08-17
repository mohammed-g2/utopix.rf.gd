<?php

namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class User
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public string $about_me;
    private DatabaseTable $posts;

    public function __construct(DatabaseTable $posts)
    {
        $this->posts = $posts;
    }

    public function getPosts() 
    {
        return $this->posts->filterBy(['user_id' => $this->id]);
    }

    public function addPost(array $post)
    {
        $post['user_id'] = $this->id;
        $this->posts->save($post);
    }
}
