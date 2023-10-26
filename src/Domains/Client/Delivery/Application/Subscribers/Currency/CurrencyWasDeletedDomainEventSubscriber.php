<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Currency;

use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyWasDeletedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CurrencyWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CurrencyWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CurrencyWasDeletedDomainEvent $event): void
    {
        $currency = $this->currencyRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($currency === null) {
            return;
        }

        $this->currencyRepository->delete($currency);
    }
}
