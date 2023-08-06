<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Create;

use Project\Domains\Client\Card\Domain\Card;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\ValueObjects\CardClientUUID;
use Project\Domains\Client\Card\Domain\ValueObjects\CardCVV;
use Project\Domains\Client\Card\Domain\ValueObjects\CardExpirationDate;
use Project\Domains\Client\Card\Domain\ValueObjects\CardHolderName;
use Project\Domains\Client\Card\Domain\ValueObjects\CardNumber;
use Project\Domains\Client\Card\Domain\ValueObjects\CardType;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CreateCardCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(CreateCardCommand $command): void
    {
        $uuid = CardUUID::fromValue($command->uuid);
        $clientUUID = CardClientUUID::fromValue($this->authManager->client()->uuid);
        $type = CardType::fromValue($command->type);
        $holderName = CardHolderName::fromValue($command->holderName);
        $number = CardNumber::fromValue($command->number);
        $cvv = CardCVV::fromValue($command->cvv);
        $expirationDate = CardExpirationDate::fromValue($command->expiration_date);

        $card = Card::crate($uuid, $clientUUID, $type, $holderName, $number, $cvv, $expirationDate);

        $this->repository->save($card);
    }
}
