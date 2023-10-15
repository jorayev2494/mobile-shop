<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\MemberWasAddedDeviceDomainEvent;
use Project\Domains\Client\Profile\Domain\Device\Device;
use Project\Domains\Client\Profile\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class MemberWasAddedDeviceDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasAddedDeviceDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasAddedDeviceDomainEvent $event): void
    {
        $profile = $this->repository->findByUuid($event->authorUuid);

        if ($profile == null) {
            return;
        }

        $device = Device::create($event->uuid, $event->deviceId);
        $profile->addDevice($device);

        $this->deviceRepository->save($device);
    }
}
