<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Profile;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface ProfileRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByUuid(string $uuid): ?Profile;
    public function save(Profile $profile): void;
}
