<?php
namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class Post 
{
    public int $id;
    public string $title;
    public string $body;
    public string $updated_at;
    public ?string $img_url;
    public int $visits;
    public bool $publish;
    public int $user_id;
    public ?int $category_id;
    private DatabaseTable $users;
    private DatabaseTable $categories;
    private ?object $user;

    public function __construct(DatabaseTable $users, DatabaseTable $categories)
    {
        $this->users = $users;
        $this->categories = $categories;
    }

    public function __toString(): string
    {
        return sprintf('<PostEntity %s>', $this->title);
    }

    public function getUser(): object
    {
        if (empty($this->user)) {
            $this->user = $this->users->getById(strval($this->user_id));
        }
        return $this->user;
    }

    public function getCategory()
    {
        if (isset($this->category_id)) {
            return $this->categories->getById($this->category_id);
        }
        else {
            return null;
        }
    }
}