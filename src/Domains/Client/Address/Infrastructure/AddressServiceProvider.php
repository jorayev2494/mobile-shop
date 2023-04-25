<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Infrastructure\Eloquent\AddressRepository;

final class AddressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }
}
