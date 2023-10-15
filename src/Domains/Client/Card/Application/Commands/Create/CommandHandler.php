<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Create;

use Project\Domains\Client\Card\Domain\Card\Card;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\AuthorUuid;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $card = Card::crate(
            Uuid::fromValue($command->uuid),
            AuthorUuid::fromValue($this->authManager->client()->uuid),
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
