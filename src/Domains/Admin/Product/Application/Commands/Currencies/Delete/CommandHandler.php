<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Currencies\Delete;

use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $currency = $this->currencyRepository->findByUuid(Uuid::fromValue($command->uuid));

        if ($currency === null) {
            throw new DomainException('Currency not found');
        }

        $currency->delete();
        $this->currencyRepository->delete($currency);
        $this->eventBus->publish(...$currency->pullDomainEvents());
    }
}
