<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure;

use Illuminate\Support\ServiceProvider;
use Project\Domains\Admin\Manager\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Admin\Manager\Application\Commands\Delete\CommandHandler as DeleteCommandHandler;
use Project\Domains\Admin\Manager\Application\Commands\Update\CommandHandler as UpdateCommandHandler;
use Project\Domains\Admin\Manager\Application\Queries\Index\QueryHandler as IndexQueryHandler;
use Project\Domains\Admin\Manager\Application\Queries\Show\QueryHandler as ShowQueryHandler;
use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Infrastructure\Eloquent\ManagerRepository;

class ManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ManagerRepositoryInterface::class, ManagerRepository::class);

        $this->app->tag(IndexQueryHandler::class, 'query_handler');
        $this->app->tag(ShowQueryHandler::class, 'query_handler');

        $this->app->tag(CreateCommandHandler::class, 'command_handler');
        $this->app->tag(UpdateCommandHandler::class, 'command_handler');
        $this->app->tag(DeleteCommandHandler::class, 'command_handler');
    }
}
