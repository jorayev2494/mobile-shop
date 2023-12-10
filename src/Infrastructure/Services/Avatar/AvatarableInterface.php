<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Avatar;

interface AvatarableInterface
{
    public function changeAvatar(?AvatarInterface $avatar): void;

    public function deleteAvatar(): void;
}
