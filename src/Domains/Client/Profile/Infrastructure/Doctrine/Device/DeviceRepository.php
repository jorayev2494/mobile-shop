<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Infrastructure\Doctrine\Device;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Profile\Domain\Device\Device;
use Project\Domains\Client\Profile\Domain\Device\DeviceRepositoryInterface;

final class DeviceRepository extends BaseClientEntityRepository implements DeviceRepositoryInterface
{
    protected function getEntity(): string
    {
        return Device::class;
    }

    public function save(Device $device): void
    {
        $this->entityRepository->getEntityManager()->persist($device);
        $this->entityRepository->getEntityManager()->flush();
    }
}
