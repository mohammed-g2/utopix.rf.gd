<?php

namespace Ninja;

class AnonymousUser
{
    public function __construct() { }

    public function __toString(): string
    {
        return '<AnonymousUser>';
    }

    public function getPosts() 
    {
        return [];
    }

    public function addPost(array $post)
    {
        return false;
    }

    public function hasPermission(int $permission): bool
    {
        return false;
    }
}
