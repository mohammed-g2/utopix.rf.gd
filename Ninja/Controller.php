<?php

namespace Ninja;

interface Controller {
    /**
     * method GET, get list of entries
     */
    public function list(): array;
    /**
     * method GET, get single entry
     */
    public function get(string $id): array;
    /**
     * method GET, return the create new entry form
     * method POST, attempt to create the entry then redirect
     */
    public function create(): array|null;
    /**
     * method GET, return update entry with given id
     * method POST, attempt to update entry then redirect
     */
    public function update(string $id): array|null;
    /**
     * method POST, attempt to delete entry then redirect
     */
    public function delete(): void;
}