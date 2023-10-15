<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Media;

interface MediaRepositoryInterface
{
    public function findByUuid(string $uuid): ?Media;

    public function delete(Media $media): void;
}
