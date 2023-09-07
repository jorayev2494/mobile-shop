<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Device;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;

final class DeviceRepository extends BaseAdminEntityRepository implements DeviceRepositoryInterface
{
    public function getEntity(): string
    {
        return Device::class;
    }

    public function findByRefreshToken(string $refreshToken): ?Device
    {
        return $this->entityRepository->findOneBy(['refreshToken' => $refreshToken]);
    }

    public function findByAuthorUuidAndDeviceId(string $authorUuid, string $deviceId): ?Device
    {
        return $this->entityRepository->findOneBy(['authorUuid' => $authorUuid, 'deviceId' => $deviceId]);
    }

    public function delete(Device $device): void
    {
        $this->entityRepository->getEntityManager()->remove($device);
        $this->entityRepository->getEntityManager()->flush();
    }
}
