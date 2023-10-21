<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Doctrine\Avatar;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Manager\Domain\Avatar\Avatar;
use Project\Domains\Admin\Manager\Domain\Avatar\AvatarRepositoryInterface;

class AvatarRepository extends BaseAdminEntityRepository implements AvatarRepositoryInterface
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
