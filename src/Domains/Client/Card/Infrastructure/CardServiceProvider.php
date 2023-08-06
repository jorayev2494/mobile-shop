<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Card\Application\Commands\Create\CreateCardCommandHandler;
use Project\Domains\Client\Card\Application\Commands\Delete\DeleteCardCommandHandler;
use Project\Domains\Client\Card\Application\Commands\Update\UpdateCardCommandHandler;
use Project\Domains\Client\Card\Application\Queries\Find\FindCardQueryHandler;
use Project\Domains\Client\Card\Application\Queries\GetCards\GetCardsQueryHandler;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Infrastructure\Repositories\EloquentCardRepository;

final class CardServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CardRepositoryInterface::class, EloquentCardRepository::class);

        $this->app->tag(GetCardsQueryHandler::class, 'query_handler');
        $this->app->tag(FindCardQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCardCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCardCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCardCommandHandler::class, 'command_handler');
    }
}
