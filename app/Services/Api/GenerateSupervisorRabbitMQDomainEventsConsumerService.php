<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Services\Api\Base\GenerateSupervisorRabbitMQConsumerService;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

final class GenerateSupervisorRabbitMQDomainEventsConsumerService extends GenerateSupervisorRabbitMQConsumerService
{

    protected function getConsumeCommandPrefix(): string
    {
        return 'domain-event';
    }

    public function configCreator(string $handlerClassName, bool $append = false): void
    {
        $name = RabbitMqQueueNameFormatter::formatFromClassName($handlerClassName);
        $queueName = $this->makeQueueNameClassName($name, $handlerClassName);

        $this->generate($queueName, $append);
    }
}
