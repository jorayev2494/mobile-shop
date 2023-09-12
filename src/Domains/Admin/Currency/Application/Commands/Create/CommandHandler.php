<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Commands\Create;

use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyUuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\CurrencyValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $currency = Currency::create(
            CurrencyUuid::fromValue($command->uuid),
            CurrencyValue::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($currency);
    }
}
