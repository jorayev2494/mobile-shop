<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommandHandler;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQueryHandler;
use Project\Domains\Client\Favorite\Domain\FavoriteRepositoryInterface;
use Project\Domains\Client\Favorite\Infrastructure\Eloquent\FavoriteRepository;

final class FavoriteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);

        $this->app->tag(GetFavoritesQueryHandler::class, 'query_handler');

        $this->app->tag(ToggleFavoriteCommandHandler::class, 'command_handler');
    }
}
