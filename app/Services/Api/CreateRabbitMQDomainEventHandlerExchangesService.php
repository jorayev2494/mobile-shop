<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Services\Api\Base\CreateRabbitMQExchangesService;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

class CreateRabbitMQDomainEventHandlerExchangesService extends CreateRabbitMQExchangesService
{    
    public function getExchangeName(): string
    {
        return 'EventExchange';
    }

    protected function make(array $consumers): array
    {
        $list = [];

        foreach ($consumers as $handler => $subscribers) {
            foreach ($subscribers as $routingKey => $domainEventClassName) {
                $name = RabbitMqQueueNameFormatter::formatFromClassName($handler);
                $queueName = $this->makeQueueNameClassName($name, $name);
                // $routingKey = $handler::eventName();
                
                $list[$queueName][$routingKey] = $name;
            }
        }

        return $list;
    }
}
