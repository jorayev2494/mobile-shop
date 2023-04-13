<?php

declare(strict_types=1);

namespace App\Services\Api\Contracts\Actions;

use App\Data\Requests\IndexRequestDTO;
use App\Models\Auth\AuthModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IndexInterface
{
    public function index(AuthModel $authModel, IndexRequestDTO $dataDTO): LengthAwarePaginator;
}
