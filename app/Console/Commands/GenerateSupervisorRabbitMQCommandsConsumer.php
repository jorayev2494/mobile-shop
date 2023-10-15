<?php

namespace App\Console\Commands;

use App\Services\Api\GenerateSupervisorRabbitMQCommandsConsumerService;
use Illuminate\Console\Command;
use Illuminate\Console\Concerns\InteractsWithIO;
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
        // Clear dirs
        $this->generateSupervisorRabbitMQCommandsConsumerService->clearDirectory();

        $output = $this->getOutput();
        $output->newLine();
        $output->text('Generating Supervisor RabbitMQ Commands Consumers');
        $output->newLine();
        $output->progressStart(count($commandHandlerLocator->all()));

        foreach ($commandHandlerLocator->all() as $handler) {
            $this->generateSupervisorRabbitMQCommandsConsumerService->configCreator($handler);
            $output->progressAdvance();
        }

        $output->progressFinish();

        return Command::SUCCESS;
    }
}
