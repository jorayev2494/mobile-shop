<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Traits;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

trait QueueName
{
    public function makeQueueName(string $value, object $handler): string
    {
        // $handlerPrefix = match (true) {
        //     $handler instanceof CommandInterface => 'Commands',
        //     $handler instanceof CommandHandlerInterface => 'Commands',
        //     $handler instanceof DomainEventSubscriberInterface => 'Product', // 'Application',
        //     $handler instanceof DomainEvent => 'Events',
        //     // default => '',
        // };
        
        // $routingKey = substr($value, 0, strpos($value, '.' . $className));

        // return substr($value, 0, strpos($value, $handlerPrefix) + strlen($handlerPrefix));

        $className = class_basename($handler);
        
        $ch = explode('.', $value);
        foreach ($ch as $key => $v) {
            if ($v === $className) {
                unset($ch[$key]);
            }
        }
        
        return implode('.', $ch);
    }
}
