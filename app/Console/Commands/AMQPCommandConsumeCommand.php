<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\RabbitMqCommandsConsumer;

class AMQPCommandConsumeCommand extends Command
{
    public function __construct(
        private readonly CommandHandlerLocator $locator,
    ) {
        parent::__construct();
    }

    protected $signature = 'rabbitmq:command-consume {--Q|queue=ddd : Queue name example: project.domains.admin.product_was_created_domain_event_handler}';

    protected $description = 'RabbitMQ Command Consume';

    public function handle(RabbitMqCommandsConsumer $consumer): int
    {
        $queue = $this->option('queue');

        $this->info(sprintf('Listening RabbitMQ queue: %s ...', $queue));

        $handler = $this->locator->withRabbitMqQueueNamed($queue);
        $consumer->consume($handler, $queue);

        return Command::SUCCESS;
    }

}
