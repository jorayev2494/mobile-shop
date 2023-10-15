<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Api\CreateRabbitMQCommandHandlerExchangesService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;

/**
 * @see https://www.cloudamqp.com/blog/how-to-run-rabbitmq-with-php.html
 */
class CreateRabbitMQCommandHandlerExchanges extends Command
{
    protected $signature = 'create-rabbitmq:command-handler-exchanges';

    protected $description = 'Create RabbitMQ Command handler exchanges';

    public function __construct(
        private readonly CreateRabbitMQCommandHandlerExchangesService $createRabbitMQCommandHandlerExchangesService,
    ) {
        parent::__construct();
    }

    public function handle(CommandHandlerLocator $commandHandlerLocator): int
    {
        $this->createRabbitMQCommandHandlerExchangesService->create($commandHandlerLocator);

        return Command::SUCCESS;
    }
}
