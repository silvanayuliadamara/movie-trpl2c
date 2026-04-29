<?php

namespace App\Services;

use App\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class MovieService
{
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getHomepageMovies(?string $search = null)
    {
        return $this->movieRepository->getAllWithSearch($search, 6);
    }

    public function getMovieDetail(int $id)
    {
        $movie = $this->movieRepository->findById($id);

        if (!$movie) {
            abort(404);
        }

        return $movie;
    }

    public function getCategories()
    {
        return $this->movieRepository->getAllCategories();
    }

    public function getMovieData()
    {
        return $this->movieRepository->getAllPaginated(10);
    }

    public function storeMovie(array $data)
    {
        if (!empty($data['foto_sampul'])) {
            $data['foto_sampul'] = $data['foto_sampul']->store('movie_covers', 'public');
        }

        return $this->movieRepository->create($data);
    }

    public function updateMovie(int $id, array $data)
    {
        $movie = $this->movieRepository->findById($id);

        if (!$movie) {
            abort(404);
        }

        if (!empty($data['foto_sampul'])) {
            if (!empty($movie->foto_sampul) && Storage::disk('public')->exists($movie->foto_sampul)) {
                Storage::disk('public')->delete($movie->foto_sampul);
            }

            $data['foto_sampul'] = $data['foto_sampul']->store('movie_covers', 'public');
        } else {
            unset($data['foto_sampul']);
        }

        return $this->movieRepository->update($id, $data);
    }

    public function deleteMovie(int $id)
    {
        $movie = $this->movieRepository->findById($id);

        if (!$movie) {
            abort(404);
        }

        if (!empty($movie->foto_sampul) && Storage::disk('public')->exists($movie->foto_sampul)) {
            Storage::disk('public')->delete($movie->foto_sampul);
        }

        return $this->movieRepository->delete($id);
    }
}
