<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Address\Application\Commands\Create\CreateCommandHandler;
use Project\Domains\Client\Address\Application\Commands\Delete\DeleteCommandHandler;
use Project\Domains\Client\Address\Application\Commands\Update\UpdateCommandHandler;
use Project\Domains\Client\Address\Application\Queries\Find\FindAddressQueryHandler;
use Project\Domains\Client\Address\Application\Queries\GetAddresses\QueryHandler as GetAddressesQueryHandler;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Infrastructure\Eloquent\AddressRepository;

final class AddressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);

        $this->app->tag(GetAddressesQueryHandler::class, 'query_handler');
        $this->app->tag(FindAddressQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');
    }
}
