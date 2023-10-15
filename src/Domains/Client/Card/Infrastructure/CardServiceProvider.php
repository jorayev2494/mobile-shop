<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure;

use App\Providers\ClientDomainServiceProvider;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\CardRepository;

final class CardServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        CardRepositoryInterface::class => [self::SERVICE_BIND, CardRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Client\Card\Application\Queries\Show\QueryHandler::class,
        \Project\Domains\Client\Card\Application\Queries\GetCards\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [
        \Project\Domains\Client\Card\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Client\Card\Application\Commands\Delete\CommandHandler::class,
        \Project\Domains\Client\Card\Application\Commands\Update\CommandHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [

    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\UuidType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\AuthorUuidType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\TypeType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\NumberType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\ExpirationDateType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\CVVType::class,
        \Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card\Types\HolderNameType::class,

    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Doctrine\Repositories\Migrations' => __DIR__ . '/Repositories/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Card',
    ];
}
