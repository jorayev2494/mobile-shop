<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Subscribers\Order;

use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Order\Events\OrderWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class OrderWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            OrderWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(OrderWasCreatedDomainEvent $event): void
    {
        $cart = $this->cartRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($cart === null) {
            return;
        }

        $this->cartRepository->delete($cart);
    }
}
