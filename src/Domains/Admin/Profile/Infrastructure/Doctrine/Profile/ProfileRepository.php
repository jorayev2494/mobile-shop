<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;

class ProfileRepository extends BaseAdminEntityRepository implements ProfileRepositoryInterface
{
    protected function getEntity(): string
    {
        return Profile::class;
    }

    public function findByUuid(string $uuid): ?Profile
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Profile $profile): void
    {
        $this->entityRepository->getEntityManager()->persist($profile);
        $this->entityRepository->getEntityManager()->flush();
    }
}
