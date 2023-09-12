<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\CurrencyRepository;

final class CurrencyServiceProvider extends AdminDomainServiceProvider
{
    protected const SERVICES = [
        CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\UuidType::class,
        \Project\Domains\Admin\Currency\Infrastructure\Doctrine\Currency\Types\ValueType::class,
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Currency\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Currency',
    ];

    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Currency\Application\Queries\Index\QueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Currency\Application\Commands\Create\CommandHandler::class,
    ];

}
