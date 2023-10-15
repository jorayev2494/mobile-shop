<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure;

use App\Http\Controllers\Api\Client\Favorite\ToggleFavoriteController;
use App\Providers\ClientDomainServiceProvider;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommandHandler;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQueryHandler;
use Project\Domains\Client\Favorite\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Infrastructure\Doctrine\Media\MediaRepository;
use Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\ProductRepository;
use Project\Domains\Client\Favorite\Infrastructure\Doctrine\Member\MemberRepository;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

final class FavoriteServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        MemberRepositoryInterface::class => [self::SERVICE_BIND, MemberRepository::class],
        ProductRepositoryInterface::class => [self::SERVICE_BIND, ProductRepository::class],
        MediaRepositoryInterface::class => [self::SERVICE_BIND, MediaRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        GetFavoritesQueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        ToggleFavoriteCommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Client\Favorite\Application\Subscribers\ProductWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Favorite\Application\Subscribers\ProductWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Favorite\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class,
        \Project\Domains\Client\Favorite\Application\Subscribers\ProductMediaWasAddedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Member
        \Project\Domains\Client\Favorite\Infrastructure\Doctrine\Member\Types\UuidType::class,

        // Product
        \Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\Types\CategoryUuidType::class,
        \Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\Types\DescriptionType::class,
        \Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\Types\TitleType::class,
        \Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product\Types\UuidType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Client\Favorite\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Member',
        __DIR__ . '/../Domain/Product',
        __DIR__ . '/../Domain/Media',
    ];

    public function register(): void
    {
        parent::register();

        // $this->app->when(ToggleFavoriteController::class)
        //             ->needs(CommandBusInterface::class)
        //             ->give(RabbitMQCommandBus::class);
    }
}
