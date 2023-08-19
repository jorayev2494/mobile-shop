<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Queries\PaginateInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

interface BaseEntityRepositoryInterface extends BaseRepository, PaginateInterface
{
    public function getEntity();
}
