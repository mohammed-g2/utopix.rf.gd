<?php

namespace Utopix\Entity;

use \Ninja\DatabaseTable;

class Category
{
    public int $id;
    public string $name;
    public string $description;
    private DatabaseTable $posts;
    private DatabaseTable $postCategory;

    public function __construct(DatabaseTable $posts, DatabaseTable $postCategory)
    {
        $this->posts = $posts;
        $this->postCategory = $postCategory;
    }

    public function getPosts(?string $orderBy=null, int $limit=0, int $offset=0): array
    {
        $results = $this->postCategory->filterBy(
            ['category_id' => $this->id], $orderBy, $limit, $offset);
        $posts = [];
        foreach ($results as $result) {
            $post = $this->posts->getById($result->post_id);
            $posts[] = $post;
        }

        return $posts;
    }
}