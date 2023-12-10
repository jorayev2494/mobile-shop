<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure\Doctrine\Avatar;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Profile\Domain\Avatar\Avatar;
use Project\Domains\Admin\Profile\Domain\Avatar\AvatarRepositoryInterface;

final class AvatarRepository extends BaseAdminEntityRepository implements AvatarRepositoryInterface
{
    protected function getEntity(): string
    {
        return Avatar::class;
    }

    public function findByUuid(string $uuid): ?Avatar
    {
        return $this->entityRepository->find($uuid);
    }

    public function delete(Avatar $avatar): void
    {
        $this->entityRepository->getEntityManager()->remove($avatar);
        $this->entityRepository->getEntityManager()->flush();
    }
}
