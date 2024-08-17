<?php
namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class Post 
{
    public int $id;
    public string $title;
    public string $body;
    public string $updated_at;
    public int $user_id;
    public int $category_id;
    private DatabaseTable $users;
    private ?object $user;

    public function __construct(DatabaseTable $users)
    {
        $this->users = $users;
    }

    public function __toString(): string
    {
        return sprintf('<PostEntity %s>', $this->title);
    }

    public function getUser()
    {
        if (empty($this->user)) {
            $this->user = $this->users->getById(strval($this->id));
        }
        return $this->user;
    }
}