<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Command;

use Project\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\RoutingKey;

final class CommandHandlerLocator implements LocatorInterface
{
    use QueueName;
    use RoutingKey;

    private readonly array $mapping;

    public function __construct(iterable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }

    public function withRabbitMqQueueNamed(string $queueName): callable
    {
        // $foundQueueName = search(
        //     // static fn (CommandHandlerInterface $handler) => ((RabbitMqQueueNameFormatter::format($handler)) === $queueName),
        //     static fn (CommandHandlerInterface $handler) => str_contains(RabbitMqQueueNameFormatter::format($handler), $queueName),
        //     $this->mapping
        // );

        $queue = static fn (): null => null;
        foreach ($this->mapping as $h) {
            if (str_contains(RabbitMqQueueNameFormatter::format($h), $queueName)) {
                $queue = $h;
                break;
            }
        }

        // dd($handler);

        // $foundQueueName = $this->makeQueueName($queueName, $handler);

        // dd($foundQueueName);

        // $foundQueueName = $this->makeRoutingKey($foundQueueName, )

        // if ($foundQueueName === null) {
        //     throw new RuntimeException("There are not found Queue Name for the <$queueName> queue");
        // }

        // if (array_key_exists($foundQueueName, $this->mapping)) {
        //     $queue = new $this->mapping[$foundQueueName];
        // }

        // if ($queue === null) {
        //     throw new RuntimeException("There are no queue for the <$queueName> queue");
        // }

        return $queue;
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
