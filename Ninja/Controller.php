<?php

namespace Ninja;

interface Controller {
    public function list(): array;
    public function get(string $id): array;
    public function create(): array|null;
    public function update(string $id): array|null;
    public function delete(): void;
}