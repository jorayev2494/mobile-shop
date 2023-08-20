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
        return $this->makeQueueNameClassName($value, class_basename($handler));
    }

    public function makeQueueNameClassName(string $value, string $handlerClassName): string
    {        
        $ch = explode('.', $value);
        foreach ($ch as $key => $v) {
            if ($v === $handlerClassName) {
                unset($ch[$key]);
            }
        }
        
        return implode('.', $ch);
    }
}
