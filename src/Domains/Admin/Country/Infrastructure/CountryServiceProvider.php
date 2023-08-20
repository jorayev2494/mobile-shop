<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure;

use App\Http\Controllers\Api\Admin\Country\CreateCountryController;
use App\Http\Controllers\Api\Admin\Country\DeleteCountryController;
use App\Http\Controllers\Api\Admin\Country\UpdateCountryController;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Country\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Admin\Country\Application\Commands\Delete\CommandHandler as DeleteCommandHandler;
use Project\Domains\Admin\Country\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Admin\Country\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Admin\Country\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Infrastructure\Eloquent\CountryRepository as EloquentCountryRepository;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\CountryRepository as DoctrineCountryRepository;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\ISOType;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\UuidType;
use Project\Domains\Admin\Country\Infrastructure\Doctrine\Types\Country\ValueType;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMQCommandBus;

final class CountryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Type::addType(ValueType::TYPE, ValueType::class);
        Type::addType(UuidType::TYPE, UuidType::class);
        Type::addType(ISOType::TYPE, ISOType::class);

        $this->app->addEntityPaths([
            __DIR__ . '/../Domain',
        ]);

        $this->app->when([
                        CreateCountryController::class,
                        UpdateCountryController::class,
                        DeleteCountryController::class,
                    ])
                    ->needs(CommandBusInterface::class)
                    ->give(RabbitMQCommandBus::class);

        // $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class); BaseEntityRepository
        $this->app->bind(CountryRepositoryInterface::class, DoctrineCountryRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');
    }
}
