<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Currency\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\PublicApi\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\PublicApi\Currency\Infrastructure\Doctrine\Currency\CurrencyRepository;

class CurrencyServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        // CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
        CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\PublicApi\Currency\Application\Queries\Index\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // \Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        // 'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        // __DIR__ . '/../Domain',
    ];
}
