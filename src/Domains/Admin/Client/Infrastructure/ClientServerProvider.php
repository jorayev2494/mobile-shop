<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure;

use App\Providers\AdminDomainServiceProvider;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Http\Controllers\Api\Admin\Client\CreateClientController;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\ClientRepository;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

final class ClientServerProvider extends AdminDomainServiceProvider
{
    protected const SERVICES = [
        ClientRepositoryInterface::class => [self::SERVICE_BIND, ClientRepository::class],
    ];

    protected const ENTITY_TYPES = [
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\UuidType::class,
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\FirstNameType::class,
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\LastNameType::class,
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\EmailType::class,
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\PhoneType::class,
        \Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\CountryUuidType::class,
    ];

    protected const QUERY_HANDLERS = [
        \Project\Domains\Admin\Client\Application\Queries\Index\QueryHandler::class,
        \Project\Domains\Admin\Client\Application\Queries\Show\QueryHandler::class,
    ];

    protected const COMMAND_HANDLERS = [
        \Project\Domains\Admin\Client\Application\Commands\Create\CommandHandler::class,
        \Project\Domains\Admin\Client\Application\Commands\Update\CommandHandler::class,
        \Project\Domains\Admin\Client\Application\Commands\Delete\CommandHandler::class,
    ];

    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Admin\Client\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber::class,
        \Project\Domains\Admin\Client\Application\Subscribers\ProfileEmailWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Client\Application\Subscribers\ProfileFirstNameWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Client\Application\Subscribers\ProfileLastNameWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Admin\Client\Application\Subscribers\ProfilePhoneWasUpdatedDomainEventSubscriber::class,
    ];

    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Client\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Client',
    ];

    public function register(): void
    {
        parent::register();

        $this->app->when([
            CreateClientController::class,
        ])
        ->needs(CommandBusInterface::class)
        ->give(RabbitMQCommandBus::class);
    }
}
