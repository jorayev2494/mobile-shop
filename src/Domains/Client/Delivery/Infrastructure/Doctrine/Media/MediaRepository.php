<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Media;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Delivery\Domain\Media\Media;
use Project\Domains\Client\Delivery\Domain\Media\MediaRepositoryInterface;

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

    public function delete(Media $media): void
    {
        $this->entityRepository->getEntityManager()->remove($media);
        $this->entityRepository->getEntityManager()->flush();
    }
}
