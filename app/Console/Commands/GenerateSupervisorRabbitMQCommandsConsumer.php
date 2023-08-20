<?php

namespace App\Console\Commands;

use App\Services\Api\GenerateSupervisorRabbitMQCommandsConsumerService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;

class GenerateSupervisorRabbitMQCommandsConsumer extends Command
{
    protected $signature = 'generate-supervisor-rabbitmq:commands-consumer';

    protected $description = 'Generate Supervisor RabbitMQ Commands Consumers';

    public function __construct(
        private readonly GenerateSupervisorRabbitMQCommandsConsumerService $generateSupervisorRabbitMQCommandsConsumerService,
    )
    {
        parent::__construct();
    }

    public function handle(CommandHandlerLocator $commandHandlerLocator): int
    {
        // dd($commandHandlerLocator->all());
        foreach ($commandHandlerLocator->all() as $handler) {
            $this->generateSupervisorRabbitMQCommandsConsumerService->configCreator($handler);
        }

        return Command::SUCCESS;
    }
}
