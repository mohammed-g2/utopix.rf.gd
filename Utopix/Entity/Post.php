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
    private DatabaseTable $users;
    private DatabaseTable $postCategories;
    private ?object $user;

    public function __construct(DatabaseTable $users, DatabaseTable $postCategories)
    {
        $this->users = $users;
        $this->postCategories = $postCategories;
    }

    public function __toString(): string
    {
        return sprintf('<PostEntity %s>', $this->title);
    }

    public function getUser(): object
    {
        if (empty($this->user)) {
            $this->user = $this->users->getById(strval($this->id));
        }
        return $this->user;
    }

    public function addCategory(string $id)
    {
        $postCategory = ['post_id' => $this->id, 'category_id' => $id];
        $this->postCategories->save($postCategory);
    }
}