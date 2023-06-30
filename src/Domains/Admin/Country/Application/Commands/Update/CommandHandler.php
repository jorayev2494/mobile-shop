<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;
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
        $foundCountry = $this->repository->findByUUID(CountryUUID::fromValue($command->uuid));

        if ($foundCountry === null) {
            throw new ModelNotFoundException();
        }

        $country = Country::fromPrimitives(
            $command->uuid,
            $command->value,
            $command->iso,
            $command->isActive,
        );

        $this->repository->save($country);
    }
}
