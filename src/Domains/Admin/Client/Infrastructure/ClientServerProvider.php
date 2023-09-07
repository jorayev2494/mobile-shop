<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Infrastructure;

use App\Http\Controllers\Api\Admin\Client\CreateClientController;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Client\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Admin\Client\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Admin\Client\Application\Delete\CommandHandler as DeleteCommandHandler;
use Project\Domains\Admin\Client\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Admin\Client\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Admin\Client\Application\Subscribers\MemberWasRegisteredDomainEventSubscriber;
use Project\Domains\Admin\Client\Application\Subscribers\ProfileEmailWasUpdatedDomainEventSubscriber;
use Project\Domains\Admin\Client\Application\Subscribers\ProfileFirstNameWasUpdatedDomainEventSubscriber;
use Project\Domains\Admin\Client\Application\Subscribers\ProfileLastNameWasUpdatedDomainEventSubscriber;
use Project\Domains\Admin\Client\Application\Subscribers\ProfilePhoneWasUpdatedDomainEventSubscriber;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\ClientRepository;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\CountryUuidType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\EmailType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\FirstNameType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\LastNameType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\PhoneType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Types\UuidType;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

class ClientServerProvider extends ServiceProvider
{
    public function register(): void
    {
        Type::addType(UuidType::TYPE, UuidType::class);
        Type::addType(FirstNameType::TYPE, FirstNameType::class);
        Type::addType(LastNameType::TYPE, LastNameType::class);
        Type::addType(EmailType::TYPE, EmailType::class);
        Type::addType(PhoneType::TYPE, PhoneType::class);
        Type::addType(CountryUuidType::TYPE, CountryUuidType::class);

        $this->app->when([
            CreateClientController::class,
        ])
        ->needs(CommandBusInterface::class)
        ->give(RabbitMQCommandBus::class);

        $this->app->addAdminEntityPaths([
            __DIR__ . '/../Domain',
        ]);

        $this->app->addAdminMigrationPaths([
            'Project\Domains\Admin\Client\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
        ]);

        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');

        $this->app->tag(MemberWasRegisteredDomainEventSubscriber::class, 'domain_event_subscriber');
        
        $this->app->tag(ProfileFirstNameWasUpdatedDomainEventSubscriber::class, 'domain_event_subscriber');
        $this->app->tag(ProfileLastNameWasUpdatedDomainEventSubscriber::class, 'domain_event_subscriber');
        $this->app->tag(ProfileEmailWasUpdatedDomainEventSubscriber::class, 'domain_event_subscriber');
        $this->app->tag(ProfilePhoneWasUpdatedDomainEventSubscriber::class, 'domain_event_subscriber');

    }
}
