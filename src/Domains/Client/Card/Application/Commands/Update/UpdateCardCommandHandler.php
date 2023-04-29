<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Commands\Update;

use Project\Domains\Client\Card\Domain\Card;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandler;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UpdateCardCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(UpdateCardCommand $command): array
    {
        $card = Card::fromPrimitives(
            $command->uuid,
            $this->authManager->client()->uuid,
            $command->type,
            $command->holder_name,
            $command->number,
            $command->cvv,
            $command->expiration_date,
            $command->is_active
        );

        $this->repository->save($card);

        return ['uuid' => $card->uuid->value];
    }
}
