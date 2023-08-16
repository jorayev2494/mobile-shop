<?php

declare(strict_types=1);

namespace App\Services\Api;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\RoutingKey;

class CreateRabbitMQExchangesAndQueueService
{
    use RoutingKey;
    use QueueName;

    private readonly AMQPChannel $channel;

    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
    )
    {
        $this->channel = $amqpConnection->channel();
    }

    public function create(LocatorInterface $handler): void
    {
        $exchangeName = $handler instanceof CommandHandlerLocator ? 'CommandExchange' : 'EventExchange';

        foreach (($this->make($handler->all())) as $queueName => $routeKeysAndHandlerNames) {
            foreach ($routeKeysAndHandlerNames as $routingKey => $classHandlerName) {
                $this->channel->exchange_declare($exchangeName, AMQPExchangeType::DIRECT, false, false, false);
                $this->channel->queue_declare($queueName, false, true, false, false);
                $this->channel->queue_bind($queueName, $exchangeName, $routingKey);
            }
        }
    }

    private function make(array $consumers): array
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
