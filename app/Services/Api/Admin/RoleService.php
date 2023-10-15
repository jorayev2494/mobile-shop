<?php

declare(strict_types=1);

namespace App\Services\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Models\Auth\AuthModel;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\Api\Admin\Contracts\RoleServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService implements RoleServiceInterface
{
    public function __construct(
        private readonly RoleRepositoryInterface $repository,
    ) {

    }

    public function index(AuthModel $authModel, IndexRequestDTO $dataDTO): LengthAwarePaginator
    {
        return $this->repository->paginate($dataDTO);
    }
}
