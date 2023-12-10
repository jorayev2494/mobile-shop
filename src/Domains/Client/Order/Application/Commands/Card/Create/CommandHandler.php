<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Card\Create;

use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid as ClientUuid;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly CardRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $client = $this->clientRepository->findByUuid(ClientUuid::fromValue($this->authManager->client()->uuid));

        $card = Card::crate(
            Uuid::fromValue($command->uuid),
            $client,
            Type::fromValue($command->type),
            HolderName::fromValue($command->holderName),
            Number::fromValue($command->number),
            CVV::fromValue($command->cvv),
            ExpirationDate::fromValue($command->expiration_date),
        );

        $this->repository->save($card);
        $this->eventBus->publish(...$card->pullDomainEvents());
    }
}
