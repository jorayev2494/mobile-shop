<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $uuid = CountryUUID::fromValue($command->uuid);
        $foundCountry = $this->repository->findByUUID($uuid);

        if ($foundCountry === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($uuid);
    }
}
