<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure;

use App\Providers\ClientDomainServiceProvider;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\CartRepository;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\CartProduct\CartProductRepository;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Category\CategoryRepository;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Media\MediaRepository;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\ProductRepository;

final class CartServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CartRepositoryInterface::class => [self::SERVICE_BIND, CartRepository::class],
        ProductRepositoryInterface::class => [self::SERVICE_BIND, ProductRepository::class],
        CartProductRepositoryInterface::class => [self::SERVICE_BIND, CartProductRepository::class],
        MediaRepositoryInterface::class => [self::SERVICE_BIND, MediaRepository::class],
        CategoryRepositoryInterface::class => [self::SERVICE_BIND, CategoryRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Client\Cart\Application\Queries\Index\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Client\Cart\Application\Commands\AddProduct\CommandHandler::class,
        \Project\Domains\Client\Cart\Application\Commands\Operator\CommandHandler::class,
        \Project\Domains\Client\Cart\Application\Commands\DeleteProduct\CommandHandler::class,
        \Project\Domains\Client\Cart\Application\Commands\Confirm\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Client\Cart\Application\Subscribers\Order\OrderWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Product\ProductWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Product\ProductWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Product\Media\ProductMediaWasAddedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Product\Media\ProductMediaWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Category\CategoryWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Cart\Application\Subscribers\Category\CategoryWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Cart
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\UuidType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\StatusType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\AuthorUuidType::class,

        // Product
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\UuidType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\TitleType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\CategoryUuidType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\DescriptionType::class,

        // Cart Product
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\CartProduct\Types\QuantityType::class,

        // Category
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Category\Types\UuidType::class,
        \Project\Domains\Client\Cart\Infrastructure\Doctrine\Category\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Client\Cart\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Cart',
        __DIR__ . '/../Domain/Product',
        __DIR__ . '/../Domain/CartProduct',
        __DIR__ . '/../Domain/Media',
        __DIR__ . '/../Domain/Category',
    ];

    public function register(): void
    {
        parent::register();
    }
}
