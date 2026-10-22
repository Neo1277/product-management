<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Contracts\ProductServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {}

    public function getProducts(
        string $search = '',
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->productRepository->paginate($search, $perPage);
    }

    public function getProduct(int $id): Product
    {
        return $this->productRepository->findById($id);
    }

    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            return $this->productRepository->create($data);
        });
    }

    public function updateProduct(int $id, array $data): Product
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->productRepository->update($id, $data);
        });
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}