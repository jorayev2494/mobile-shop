<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Card;

use Project\Domains\Client\Card\Domain\Card\Events\CardWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CardWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            CardWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CardWasCreatedDomainEvent $event): void
    {
        $client = $this->clientRepository->findByUuid(Uuid::fromValue($event->authorUuid));

        $card = Card::fromPrimitives(
            $event->uuid,
            $event->type,
            $event->holderName,
            $event->number,
            $event->cvv,
            $event->expirationDate,
        );

        $client->addCard($card);
        $this->clientRepository->save($client);
    }
}
