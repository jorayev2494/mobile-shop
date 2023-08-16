<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure;

use App\Http\Controllers\Api\Client\Favorite\ToggleFavoriteController;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommandHandler;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQueryHandler;
use Project\Domains\Client\Favorite\Domain\FavoriteRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Infrastructure\Eloquent\FavoriteRepository;
use Project\Domains\Client\Favorite\Infrastructure\Eloquent\MemberRepository;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

final class FavoriteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ToggleFavoriteController::class)
                    ->needs(CommandBusInterface::class)
                    ->give(RabbitMQCommandBus::class);

        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);

        $this->app->tag(GetFavoritesQueryHandler::class, 'query_handler');

        $this->app->tag(ToggleFavoriteCommandHandler::class, 'command_handler');
    }
}
