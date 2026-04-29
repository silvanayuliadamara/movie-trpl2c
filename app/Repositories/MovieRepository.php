<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Models\Category;
use App\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllWithSearch(?string $search = null, int $perPage = 6)
    {
        $query = Movie::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('sinopsis', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return Movie::latest()->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Movie::findOrFail($id);
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function create(array $data)
    {
        return Movie::create($data);
    }

    public function update(int $id, array $data)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($data);

        return $movie;
    }

    public function delete(int $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return true;
    }
}
