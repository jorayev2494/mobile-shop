<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqDomainEventsConsumer;

class AMQPConsumeCommand extends Command
{

    // project.domains.admin.product_was_created_domain_event_handler
    // project.domains.admin.productWasCreatedDomainEventHandler
    public function __construct(
        private readonly DomainEventSubscriberLocator $locator,
    )
    {
        parent::__construct();
    }

    protected $signature = 'rabbitmq:consume {--Q|queue=ddd : Queue name example: project.domains.admin.product_was_created_domain_event_handler}';

    protected $description = 'RabbitMQ Consume';

    public function handle(RabbitMqDomainEventsConsumer $consumer): int
    {
        $queue = $this->option('queue');

        $this->info(sprintf('Listening RabbitMQ queue: %s ...', $queue));

        $subscriberHandler = $this->locator->withRabbitMqQueueNamed($queue);
        $consumer->consume($subscriberHandler, $queue);

        return Command::SUCCESS;
    }
}
