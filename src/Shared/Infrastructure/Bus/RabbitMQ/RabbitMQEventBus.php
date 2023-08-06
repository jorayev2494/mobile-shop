<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

final class RabbitMQEventBus implements EventBusInterface
{
    public const EVENT_CLASS_KEY = 'event_class';
    private const EXCHANGE_NAME = 'test_exchange';

    private readonly AMQPChannel $channel;

    private array $properties = [];

    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
    )
    {
        $this->channel = $amqpConnection->channel();
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->publishEvent($event);
            } catch (NoHandlerForMessageException) {
                // TODO optionally throw exception or not
            }
        }
    }

    private function publishEvent(DomainEvent $event): void
    {
        $messageId = $event->eventId();
        $routingKey = $event->eventName();
        $body = $this->serializeDomainEvent($event);

        $this->setProperties([
            'message_id'            => $messageId,
            'content_type'          => 'application/json',
            'content_encoding'      => 'utf-8',
        ]);

        $this->setHeader([
            self::EVENT_CLASS_KEY   => $event::class,
        ]);

        $msg = new AMQPMessage($body, $this->getProperties());
        // dd(compact('routingKey'));
        // https://www.cloudamqp.com/blog/how-to-run-rabbitmq-with-php.html
        $this->channel->basic_publish($msg, $event::exchangeName(), $routingKey);
    }

    private function getProperties(): array
    {
        return $this->properties;
    }

    private function serializeDomainEvent(DomainEvent $event): string
    {
        return json_encode($event->toArray(), JSON_FORCE_OBJECT);
    }

    private function setProperty(string $key, string $value): void
    {
        $this->properties[$key] = $value;
    }

    /**
     * @param array<string, string> $data
     * @return void
     */
    private function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    private function setHeader(array $value): void
    {
        $this->properties['application_headers'] = new AMQPTable($value);
    }
}
