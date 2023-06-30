<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Country\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Admin\Country\Application\Commands\Delete\CommandHandler as DeleteCommandHandler;
use Project\Domains\Admin\Country\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Admin\Country\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Admin\Country\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Infrastructure\Eloquent\CountryRepository;

final class CountryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');
    }
}
