<?php

namespace App\Console\Commands;

use App\Services\Api\CreateRabbitMQExchangesAndQueueService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;

class CreateRabbitMQExchanges extends Command
{
    protected $signature = 'create-rabbitmq-exchanges';

    protected $description = 'Command description';

    public function __construct(
        private readonly CreateRabbitMQExchangesAndQueueService $createRabbitMQExchangesService,
    )
    {
        parent::__construct();
    }

    public function handle(
        DomainEventSubscriberLocator $domainEventSubscriberLocator,
        CommandHandlerLocator $commandHandlerLocator,
    ): int
    {
        $locators = [
            // $domainEventSubscriberLocator,
            $commandHandlerLocator,
        ];

        foreach ($locators as $locator) {
            $this->createRabbitMQExchangesService->create($locator);
        }

        return Command::SUCCESS;
    }
}
