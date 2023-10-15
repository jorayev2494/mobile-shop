<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Subscribers;

use Project\Domains\Admin\Authentication\Domain\Member\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasRegisteredDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasRegisteredDomainEvent $event): void
    {
        $profile = Profile::create(
            $event->uuid,
            ProfileFirstName::fromValue(null),
            ProfileLastName::fromValue(null),
            ProfileEmail::fromValue($event->email),
            ProfilePhone::fromValue(null),
        );

        $this->repository->save($profile);
    }
}
