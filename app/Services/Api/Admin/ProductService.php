<?php

declare(strict_types=1);

namespace App\Services\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Models\Auth\AuthModel;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Api\Admin\Contracts\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {

    }

    public function index(AuthModel $authModel, IndexRequestDTO $dataDTO): LengthAwarePaginator
    {
        return $this->repository->paginate($dataDTO);
    }
}
