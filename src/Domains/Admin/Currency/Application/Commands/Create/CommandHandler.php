<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Commands\Create;

use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $currency = Currency::create(
            Uuid::fromValue($command->uuid),
            Value::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($currency);
        $this->eventBus->publish(...$currency->pullDomainEvents());
    }
}
