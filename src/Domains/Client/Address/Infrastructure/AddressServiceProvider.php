<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Infrastructure;

use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Client\Address\Application\Commands\Create\CreateCommandHandler;
use Project\Domains\Client\Address\Application\Commands\Delete\CommandHandler as DeleteCommandHandler;
use Project\Domains\Client\Address\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Client\Address\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Client\Address\Application\Queries\GetAddresses\QueryHandler as GetAddressesQueryHandler;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Infrastructure\Doctrine\AddressRepository;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\CityUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\AuthorUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\CountryUuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\DistrictType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\FirstAddressType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\FullNameType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\SecondAddressType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\TitleType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\UuidType;
use Project\Domains\Client\Address\Infrastructure\Doctrine\Types\ZipCodeType;

final class AddressServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Type::addType(UuidType::NAME, UuidType::class);
        Type::addType(TitleType::NAME, TitleType::class);
        Type::addType(FullNameType::NAME, FullNameType::class);
        Type::addType(AuthorUuidType::NAME, AuthorUuidType::class);
        Type::addType(FirstAddressType::NAME, FirstAddressType::class);
        Type::addType(SecondAddressType::NAME, SecondAddressType::class);
        Type::addType(ZipCodeType::NAME, ZipCodeType::class);
        Type::addType(CountryUuidType::NAME, CountryUuidType::class);
        Type::addType(CityUuidType::NAME, CityUuidType::class);
        Type::addType(DistrictType::NAME, DistrictType::class);

        $this->app->addClientEntityPaths([
            __DIR__ . '/../Domain',
        ]);

        $this->app->addClientMigrationPaths([
            'Project\Domains\Client\Address\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
        ]);

        // $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);

        $this->app->tag(GetAddressesQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');
    }
}
