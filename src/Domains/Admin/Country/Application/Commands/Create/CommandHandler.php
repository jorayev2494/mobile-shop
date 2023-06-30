<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Commands\Create;

use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public readonly CountryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $country = Country::create(
            CountryUUID::fromValue($command->uuid),
            CountryValue::fromValue($command->value),
            CountryISO::fromValue($command->iso),
            $command->isActive,
        );

        $this->repository->save($country);
    }
}
