<?php
namespace Utopix\Controllers;

use \Ninja\DatabaseTable;
use \Ninja\Controller;


class Categories implements Controller
{
    private DatabaseTable $categories;

    public function __construct(DatabaseTable $categories)
    {
        $this->categories = $categories;
    }

    public function __toString()
    {
        return '<Controller Category>';
    }

    /**
     * method GET, get list of entries
     */
    public function list(): array
    {
        return [];
    }

    /**
     * method GET, get single entry
     */
    public function get(string $id): array
    {
        return [];
    }

    /**
     * method GET, return the create new entry form
     * method POST, attempt to create the entry then redirect
     */
    public function create(): array|null
    {
        return [];
    }

    /**
     * method GET, return update entry with given id
     * method POST, attempt to update entry then redirect
     */
    public function update(string $id): array|null
    {
        return [];
    }

    /**
     * method POST, attempt to delete entry then redirect
     */
    public function delete(): void
    {
        return;
    }




}