<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Card\Update;

use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
    ) {

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
