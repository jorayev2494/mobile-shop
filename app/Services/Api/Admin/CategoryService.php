<?php

declare(strict_types=1);

namespace App\Services\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Models\Auth\AuthModel;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Api\Admin\Contracts\CategoryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    )
    {
        
    }

    public function index(AuthModel $authModel, IndexRequestDTO $dataDTO): LengthAwarePaginator
    {
        return $this->repository->paginate($dataDTO);
    }
}
