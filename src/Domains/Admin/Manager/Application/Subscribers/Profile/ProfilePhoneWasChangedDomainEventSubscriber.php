<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers\Profile;

use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfilePhoneWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ProfilePhoneWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfilePhoneWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ProfilePhoneWasChangedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($event->uuid));

        if ($manager === null) {
            return;
        }

        $manager->setPhone(ManagerPhone::fromValue($event->phone));

        $this->repository->save($manager);
    }
}
