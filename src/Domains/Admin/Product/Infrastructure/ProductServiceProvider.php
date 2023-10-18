<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Media\MediaRepository;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\ProductRepository;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Category\CategoryRepository;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Currency\CurrencyRepository;

final class ProductServiceProvider extends AdminDomainServiceProvider
{
    protected const SERVICES = [
        ProductRepositoryInterface::class => [self::SERVICE_BIND,  ProductRepository::class],
        MediaRepositoryInterface::class => [self::SERVICE_BIND,  MediaRepository::class],
        CategoryRepositoryInterface::class => [self::SERVICE_BIND, CategoryRepository::class],
        CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
    ];

    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Product\Application\Queries\Find\QueryHandler::class,
        \Project\Domains\Admin\Product\Application\Queries\Get\QueryHandler::class,

        \Project\Domains\Admin\Product\Application\Queries\Categories\Find\QueryHandler::class,
        \Project\Domains\Admin\Product\Application\Queries\Categories\Get\QueryHandler::class,

        \Project\Domains\Admin\Product\Application\Queries\Currencies\Index\QueryHandler::class,
        \Project\Domains\Admin\Product\Application\Queries\Currencies\Show\QueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Product\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Delete\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Update\CommandHandler::class,

        \Project\Domains\Admin\Product\Application\Commands\Categories\Create\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Categories\Update\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Categories\Delete\CommandHandler::class,

        \Project\Domains\Admin\Product\Application\Commands\Currencies\Create\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Currencies\Update\CommandHandler::class,
        \Project\Domains\Admin\Product\Application\Commands\Currencies\Delete\CommandHandler::class,
    ];

    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Product\Application\Subscribers\ProductMediaWasAddedDomainEventSubscriber::class,
        \Project\Domains\Admin\Product\Application\Subscribers\ProductWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Product\Application\Subscribers\ProductWasDeletedDomainEventSubscriber::class,
    ];

    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\UuidType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\TitleType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\CategoryUuidType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\DescriptionType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Category\Types\UuidType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Category\Types\ValueType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Currency\Types\UuidType::class,
        \Project\Domains\Admin\Product\Infrastructure\Doctrine\Currency\Types\ValueType::class,
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Product\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Category',
        __DIR__ . '/../Domain/Product',
        __DIR__ . '/../Domain/Media',
        __DIR__ . '/../Domain/Currency',
    ];
}
