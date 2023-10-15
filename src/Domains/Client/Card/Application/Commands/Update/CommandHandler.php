<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Update;

use DomainException;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $card = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($card === null) {
            throw new DomainException('Card not found');
        }

        $card->changeHolderName(HolderName::fromValue($command->holderName));
        $card->changeType(Type::fromValue($command->type));
        $card->changeNumber(Number::fromValue($command->number));
        $card->changeCVV(CVV::fromValue($command->cvv));
        $card->changeExpirationDate(ExpirationDate::fromValue($command->expirationDate));

        $this->repository->save($card);
    }
}
