<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Update;

use Project\Domains\Client\Card\Domain\Card;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UpdateCardCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(UpdateCardCommand $command): void
    {
        $card = Card::fromPrimitives(
            $command->uuid,
            $this->authManager->client()->uuid,
            $command->type,
            $command->holderName,
            $command->number,
            $command->cvv,
            $command->expirationDate,
        );

        $this->repository->save($card);
    }
}
