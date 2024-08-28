<?php

namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class User
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public ?string $about_me;
    public int $permissions;
    private DatabaseTable $posts;
    private ?array $userPosts;

    const EDIT_POST = 1;
    const DELETE_POST = 2;
    const EDIT_CATEGORY = 4;
    const DELETE_CATEGORY = 8;
    const EDIT_USER_ACCESS = 16;

    public function __construct(DatabaseTable $posts)
    {
        $this->posts = $posts;
    }

    public function __toString(): string
    {
        return sprintf('<UserEntity %s>', $this->username);
    }

    /**
     * get posts written by user
     */
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
        return $this->posts->save($post);
    }

    /**
     * check if user have given permission
     */
    public function hasPermission(int $permission): bool
    {
        return $this->permissions & $permission;
    }

    public static function adminPermissions(): int
    {
        return \Utopix\Entity\User::EDIT_POST
            + \Utopix\Entity\User::DELETE_POST
            + \Utopix\Entity\User::EDIT_CATEGORY
            + \Utopix\Entity\User::DELETE_CATEGORY
            + \Utopix\Entity\User::EDIT_USER_ACCESS;
    }
}
