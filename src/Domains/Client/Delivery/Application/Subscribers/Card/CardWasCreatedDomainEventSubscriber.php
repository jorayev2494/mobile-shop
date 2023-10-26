<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Card;

use Project\Domains\Client\Card\Domain\Card\Events\CardWasCreatedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Card\Card;
use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CardWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CustomerRepositoryInterface $customerRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CardWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CardWasCreatedDomainEvent $event): void
    {
        $client = $this->customerRepository->findByUuid(Uuid::fromValue($event->authorUuid));

        $card = Card::fromPrimitives(
            $event->uuid,
            $event->type,
            $event->holderName,
            $event->number,
            $event->cvv,
            $event->expirationDate,
        );

        $client->addCard($card);
        $this->customerRepository->save($client);
    }
}
