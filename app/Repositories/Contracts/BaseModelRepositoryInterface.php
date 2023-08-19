<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Queries\PaginateInterface;

interface BaseModelRepositoryInterface extends BaseRepository, PaginateInterface
{
    public function getModel(): string;
}
