<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\DeviceWasRemovedDomainEvent;
use Project\Domains\Client\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Client\Profile\Infrastructure\Doctrine\Device\DeviceRepository;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class DeviceWasRemovedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly DeviceRepository $deviceRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            DeviceWasRemovedDomainEvent::class,
        ];
    }

    public function __invoke(DeviceWasRemovedDomainEvent $event): void
    {
        $profile = $this->repository->findByUuid($event->authorUuid);
        $device = $this->deviceRepository->findByUuid($event->uuid);

        if ($profile === null || $device === null) {
            return;
        }

        $profile->removeDevice($device);
        $this->repository->save($profile);
    }
}
