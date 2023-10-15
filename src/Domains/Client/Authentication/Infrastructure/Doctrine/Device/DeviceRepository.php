<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Device;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;

final class DeviceRepository extends BaseClientEntityRepository implements DeviceRepositoryInterface
{
    protected function getEntity(): string
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
