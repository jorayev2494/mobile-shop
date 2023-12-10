<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Avatar;

use Illuminate\Http\UploadedFile;

interface AvatarServiceInterface
{
    public function update(AvatarableInterface $entity, ?UploadedFile $avatar): void;

    public function delete(AvatarableInterface $entity): void;
}
