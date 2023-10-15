<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Services\Api\Base\CreateRabbitMQExchangesService;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

class CreateRabbitMQCommandHandlerExchangesService extends CreateRabbitMQExchangesService
{
    public function getExchangeName(): string
    {
        return 'CommandExchange';
    }

    protected function make(array $consumers): array
    {
        $list = [];

        foreach ($consumers as $key => $handler) {
            $name = RabbitMqQueueNameFormatter::format($handler);
            $queueName = $this->makeQueueName($name, $handler);
            $routeName = $this->makeRoutingKey($name, $handler);

            $list[$queueName][$routeName] = $name;
        }

        return $list;
    }
}
