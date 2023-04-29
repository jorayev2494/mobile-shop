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
use Project\Shared\Domain\Bus\Command\CommandHandler;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CreateCardCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(CreateCardCommand $command): array
    {
        $uuid = CardUUID::generate();
        $clientUUID = CardClientUUID::fromValue($this->authManager->client()->uuid);
        $type = CardType::fromValue($command->type);
        $holderName = CardHolderName::fromValue($command->holder_name);
        $number = CardNumber::fromValue($command->number);
        $cvv = CardCVV::fromValue($command->cvv);
        $expirationDate = CardExpirationDate::fromValue($command->expiration_date);
        $isActive = $command->is_active;

        $card = Card::crate($uuid, $clientUUID, $type, $holderName, $number, $cvv, $expirationDate, $isActive);

        $this->repository->save($card);

        return ['uuid' => $uuid->value];
    }
}
