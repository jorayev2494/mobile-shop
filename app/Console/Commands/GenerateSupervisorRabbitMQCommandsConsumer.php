<?php

namespace App\Console\Commands;

use App\Services\Api\GenerateSupervisorRabbitMQConsumerService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;

class GenerateSupervisorRabbitMQCommandsConsumer extends Command
{
    protected $signature = 'generate-supervisor-rabbitmq-consumer';

    protected $description = 'Generate Supervisor RabbitMQ Consumers';

    public function __construct(
        private readonly GenerateSupervisorRabbitMQConsumerService $generateSupervisorRabbitMQConsumerService,
    )
    {
        parent::__construct();
    }

    public function handle(CommandHandlerLocator $commandHandlerLocator): int
    {
        foreach ($commandHandlerLocator->all() as $handler) {
            $this->generateSupervisorRabbitMQConsumerService->configCreator($handler);
        }

        return Command::SUCCESS;
    }
}
