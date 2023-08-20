<?php

namespace App\Console\Commands;

use App\Services\Api\GenerateSupervisorRabbitMQDomainEventsConsumerService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventLocator;

class GenerateSupervisorRabbitMQEventsConsumer extends Command
{
    protected $signature = 'generate-supervisor-rabbitmq:domain-events-consumer';

    protected $description = 'Generate Supervisor RabbitMQ Domain Event Consumers';

    public function __construct(
        private readonly GenerateSupervisorRabbitMQDomainEventsConsumerService $generateSupervisorRabbitMQDomainEventsConsumerService,
    )
    {
        parent::__construct();
    }

    public function handle(DomainEventLocator $domainEventLocator): int
    {
        foreach ($domainEventLocator->all() as $handler => $subscribersTo) {
            $this->generateSupervisorRabbitMQDomainEventsConsumerService->configCreator($handler);
        }

        return Command::SUCCESS;
    }
}
