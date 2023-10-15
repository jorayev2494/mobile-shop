<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Favorite\Domain\Member\Member;
use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class MemberWasRegisteredDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $memberRepository
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            MemberWasRegisteredDomainEvent::class,
        ];
    }

    public function __invoke(MemberWasRegisteredDomainEvent $event): void
    {
        $member = Member::create(MemberUuid::fromValue($event->uuid));

        $this->memberRepository->save($member);
    }
}
