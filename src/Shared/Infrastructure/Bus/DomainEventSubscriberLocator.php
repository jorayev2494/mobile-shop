<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus;

use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

use function Lambdish\Phunctional\search;
use RuntimeException;
use Traversable;

final class DomainEventSubscriberLocator
{
    private readonly array $mapping;

    public function __construct(Traversable $mapping)
    {
        $this->mapping = iterator_to_array($mapping);
    }

    public function allSubscribedTo(string $eventClass): array
    {
        $formatted = CallableFirstParameterExtractor::forPipedCallables($this->mapping);

        return $formatted[$eventClass];
    }

    public function withRabbitMqQueueNamed(string $queueName): DomainEventSubscriberInterface|callable
    {
        // project.domains.admin.product_was_created_domain_event_handler
        $subscriber = search(
            static fn (DomainEventSubscriberInterface $subscriber) => RabbitMqQueueNameFormatter::format($subscriber) === $queueName,
            $this->mapping
        );
        
        if (array_key_exists($queueName, $this->mapping)) {
            $subscriber = new $this->mapping[$queueName];
        }

        if (null === $subscriber) {
            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
        }

        return $subscriber;
    }

    public function all(): array
    {
        return $this->mapping;
    }
}
