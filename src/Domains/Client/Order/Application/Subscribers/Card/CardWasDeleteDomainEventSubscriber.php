<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Card;

use Project\Domains\Client\Card\Domain\Card\Events\CardWasDeleteDomainEvent;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CardWasDeleteDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $cardRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CardWasDeleteDomainEvent::class,
        ];
    }

    public function __invoke(CardWasDeleteDomainEvent $event): void
    {
        $card = $this->cardRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($card === null) {
            return;
        }

        $this->cardRepository->delete($card);
    }
}
