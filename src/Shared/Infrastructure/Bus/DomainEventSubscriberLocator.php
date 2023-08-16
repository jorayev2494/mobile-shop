<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus;

use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Infrastructure\Bus\Contracts\LocatorInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;

use function Lambdish\Phunctional\search;
use RuntimeException;
use Traversable;

final class DomainEventSubscriberLocator implements LocatorInterface
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
        // dd($queueName, $this->mapping);
        // project.domains.admin.product_was_created_domain_event_handler
        // project.domains.admin.productWasCreatedDomainEventHandler
        $subscriber = search(
            static fn (DomainEventSubscriberInterface $subscriber) => (RabbitMqQueueNameFormatter::format($subscriber)) === $queueName,
            $this->mapping
        );
        
        if (array_key_exists($subscriber, $this->mapping)) {
            $subscriber = new $this->mapping[$subscriber];
        }

        // dd($subscriber, $this->mapping);

        if (null === $subscriber) {
            throw new RuntimeException("There are no subscribers for the <$queueName> queue");
        }

        return $subscriber;
    }

    public function all(): array
    {
        return $this->mapping;
    }

    public function getRegisteredSubscribers(): array
    {
        $list = array_map(
            static fn (DomainEventSubscriberInterface $subscriber) => RabbitMqQueueNameFormatter::format($subscriber),
            $this->mapping
        );

        return $list;
    }
}
