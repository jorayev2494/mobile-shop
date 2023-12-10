<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Avatar;

interface AvatarRepositoryInterface
{
    public function findByUuid(string $uuid): ?Avatar;

    public function delete(Avatar $avatar): void;
}
