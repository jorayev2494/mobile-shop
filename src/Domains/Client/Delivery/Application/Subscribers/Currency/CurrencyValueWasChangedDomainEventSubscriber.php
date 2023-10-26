<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Currency;

use Project\Domains\Client\Delivery\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\Events\CurrencyValueWasChangedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Client\Delivery\Domain\Currency\ValueObjects\Value;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CurrencyValueWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CurrencyValueWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(CurrencyValueWasChangedDomainEvent $event): void
    {
        $currency = $this->currencyRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($currency === null) {
            return;
        }

        $currency->setValue(Value::fromValue($event->value));

        $this->currencyRepository->save($currency);
    }
}
