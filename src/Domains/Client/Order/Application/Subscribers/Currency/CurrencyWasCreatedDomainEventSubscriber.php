<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Currency;

use Project\Domains\Admin\Currency\Domain\Currency\Events\CurrencyWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CurrencyWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            CurrencyWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CurrencyWasCreatedDomainEvent $event): void
    {
        $currency = Currency::fromPrimitives($event->uuid, $event->value, $event->isActive);

        $this->currencyRepository->save($currency);
    }
}
