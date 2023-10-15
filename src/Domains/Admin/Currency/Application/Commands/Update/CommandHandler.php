<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Commands\Update;

use DomainException;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

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

        $currency->changeValue(Value::fromValue($command->value));
        $currency->changeIsActive($command->isActive);

        $this->currencyRepository->save($currency);
        $this->eventBus->publish(...$currency->pullDomainEvents());
    }
}
