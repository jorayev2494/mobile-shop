<?php

declare(strict_types=1);

namespace Project\Domains\Client\Country\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Country\Application\Queries\Index\QueryHandler;
use Project\Domains\Client\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Client\Country\Infrastructure\Eloquent\CountryRepository;

class CountryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);

        $this->app->tag(QueryHandler::class, 'query_handler');
    }
}
