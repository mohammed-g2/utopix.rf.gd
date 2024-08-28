<?php

namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class Category
{
    public int $id;
    public string $name;
    public ?string $description;
    public ?string $img_url;
    private DatabaseTable $posts;

    public function __construct(DatabaseTable $posts)
    {
        $this->posts = $posts;
    }

    public function getPosts(?string $orderBy=null, int $limit=0, int $offset=0): array
    {
        $posts = $this->posts->filterBy(['category_id' => $this->id]);
        return $posts;
    }
}