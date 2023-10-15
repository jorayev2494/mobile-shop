<?php

namespace App\Console\Commands;

use App\Services\Api\CreateRabbitMQDomainEventHandlerExchangesService;
use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventLocator;

/**
 * @see https://www.cloudamqp.com/blog/how-to-run-rabbitmq-with-php.html
 */
class CreateRabbitMQDomainEventHandlerExchanges extends Command
{
    protected $signature = 'create-rabbitmq:domain-event-handler-exchanges';

    protected $description = 'Create RabbitMQ Domain Event handler exchanges';

    public function __construct(
        private readonly CreateRabbitMQDomainEventHandlerExchangesService $createRabbitMQDomainEventHandlerExchangesService,
    )
    {
        parent::__construct();
    }

    public function handle(DomainEventLocator $domainEventLocator): int
    {
        $this->createRabbitMQDomainEventHandlerExchangesService->create($domainEventLocator);

        return Command::SUCCESS;
    }
}
