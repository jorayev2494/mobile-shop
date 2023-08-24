<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryEntity;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
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
        $foundCountry = $this->repository->findByUuid(CountryUuid::fromValue($command->uuid));

        if ($foundCountry === null) {
            throw new ModelNotFoundException();
        }

        $foundCountry->setValue(CountryValue::fromValue($command->value));
        $foundCountry->setISO(CountryISO::fromValue($command->iso));

        $this->repository->save($foundCountry);
    }
}
