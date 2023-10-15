<?php

declare(strict_types=1);

namespace App\Services\Api\Base;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\RoutingKey;

abstract class CreateRabbitMQExchangesService
{
    use RoutingKey;
    use QueueName;

    private readonly AMQPChannel $channel;
    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
    ) {
        $this->channel = $amqpConnection->channel();
    }

    abstract public function getExchangeName(): string;

    abstract protected function make(array $consumers): array;

    public function create(LocatorInterface $handler): void
    {
        foreach (($this->make($handler->all())) as $queueName => $routeKeysAndHandlerNames) {
            foreach ($routeKeysAndHandlerNames as $routingKey => $classHandlerName) {
                $this->channel->exchange_declare($this->getExchangeName(), AMQPExchangeType::DIRECT, false, false, false);
                $this->channel->queue_declare($queueName, false, true, false, false);
                $this->channel->queue_bind($queueName, $this->getExchangeName(), $routingKey);
            }
        }
    }
}
