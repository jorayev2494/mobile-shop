<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Currency\Domain\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Infrastructure\Eloquent\CurrencyRepository;

class CurrencyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);

        $this->app->tag(\Project\Domains\Admin\Currency\Application\Queries\Index\QueryHandler::class, 'query_handler');
    }
}
