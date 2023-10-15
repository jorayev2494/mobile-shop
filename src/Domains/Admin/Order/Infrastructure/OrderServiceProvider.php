<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Order\Application\Queries\Show\ShowOrderQueryHandler;
use Project\Domains\Admin\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Admin\Order\Infrastructure\Doctrine\Order\OrderRepository;

final class OrderServiceProvider extends AdminDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        OrderRepositoryInterface::class => [self::SERVICE_BIND, OrderRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Order\Application\Queries\Get\QueryHandler::class,
        ShowOrderQueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Order\Application\Commands\Update\CommandHandler::class,
    ];

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
        // __DIR__ . '/../Domain/Order',
    ];
}
