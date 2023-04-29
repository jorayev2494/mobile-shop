<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Infrastructure\Repositories\EloquentCardRepository;

final class CardServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CardRepositoryInterface::class, EloquentCardRepository::class);
    }
}
