<?php

namespace App\Interfaces;

interface MovieRepositoryInterface
{
    public function getAllWithSearch(?string $search = null, int $perPage = 6);
    public function getAllPaginated(int $perPage = 10);
    public function findById(int $id);
    public function getAllCategories();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
