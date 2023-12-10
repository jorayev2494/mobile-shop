<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Address\Create;

use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CityUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\CountryUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\District;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FirstAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\FullName;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\SecondAddress;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Title;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\ZipCode;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $address = Address::create(
            Uuid::fromValue($command->uuid),
            Title::fromValue($command->title),
            FullName::fromValue($command->fullName),
            AuthorUuid::fromValue($this->authManager->client()->uuid),
            FirstAddress::fromValue($command->firstAddress),
            SecondAddress::fromValue($command->secondAddress),
            ZipCode::fromValue($command->zipCode),
            CountryUuid::fromValue($command->countryUuid),
            CityUuid::fromValue($command->cityUuid),
            District::fromValue($command->district),
        );

        $this->repository->save($address);
        $this->eventBus->publish(...$address->pullDomainEvents());
    }
}
