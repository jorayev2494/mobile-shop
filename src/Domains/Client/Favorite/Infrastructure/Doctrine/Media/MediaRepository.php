<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Doctrine\Media;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Favorite\Domain\Media\Media;
use Project\Domains\Client\Favorite\Domain\Media\MediaRepositoryInterface;

final class MediaRepository extends BaseClientEntityRepository implements MediaRepositoryInterface
{
    protected function getEntity(): string
    {
        return Media::class;
    }

    public function findByUuid(string $uuid): ?Media
    {
        return $this->entityRepository->find($uuid);
    }
}
