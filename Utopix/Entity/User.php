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
    private ?array $userPosts;

    public function __construct(DatabaseTable $posts)
    {
        $this->posts = $posts;
    }

    public function __toString(): string
    {
        return sprintf('<UserEntity %s>', $this->username);
    }

    public function getPosts() 
    {
        if (empty($this->userPosts)) {
            $this->userPosts = $this->posts->filterBy(['user_id' => $this->id]);
        }
        return $this->userPosts;
    }

    public function addPost(array $post)
    {
        $post['user_id'] = $this->id;
        $this->posts->save($post);
    }
}
