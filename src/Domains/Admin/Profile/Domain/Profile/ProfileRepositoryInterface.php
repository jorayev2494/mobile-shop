<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Profile;

interface ProfileRepositoryInterface
{
    public function findByUuid(string $uuid): ?Profile;
    public function save(Profile $profile): void;
}
