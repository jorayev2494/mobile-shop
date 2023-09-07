<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

interface BaseEntityRepositoryInterface
{
    public function getEntity(): string;
}
