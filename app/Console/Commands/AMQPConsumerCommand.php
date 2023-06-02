<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqDomainEventsConsumer;

class AMQPConsumerCommand extends Command
{

    public function __construct(
        private readonly DomainEventSubscriberLocator $locator,
    )
    {
        parent::__construct();
    }

    protected $signature = 'rabbitmq:consumer {--Q|queue=ddd : Queue name}';

    protected $description = 'RabbitMQ Consumer';

    public function handle(RabbitMqDomainEventsConsumer $consumer): int
    {
        $queue = $this->option('queue');

        $this->info(sprintf('Listening RabbitMQ queue: %s ...', $queue));

        $subscriberHandler = $this->locator->withRabbitMqQueueNamed($queue);
        $consumer->consume($subscriberHandler, $queue);

        return Command::SUCCESS;
    }
}
