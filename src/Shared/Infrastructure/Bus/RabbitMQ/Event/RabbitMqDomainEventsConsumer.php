<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Event;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use Project\Utils\JSON;
use RuntimeException;

final class RabbitMqDomainEventsConsumer
{
    private readonly AMQPChannel $channel;

    private AMQPMessage $msg;

    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
    )
    {
        $this->channel = $amqpConnection->channel();
        $this->channel->basic_qos(null, 1, null);
    }

    public function consume(callable $subscriber, string $queueName): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);

        try {
            $this->channel->basic_consume($queueName, '', false, false, false, false, $this->consumer($subscriber, $queueName));
        } catch (\Exception $ex) {
            // info(__METHOD__, [$ex->__toString()]);
            // dd('ees');
            // We don't want to raise an error if there are no messages in the queue
        }

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->channel->close();
        $this->amqpConnection->close();
    }

    private function consumer(callable $subscriber, string $queueName): callable
    {
        return function (AMQPMessage $msg) use($subscriber, $queueName): void {
            $event = $this->deserializeDomainEvent($msg);

            try {
                $subscriber($event);
                $this->consoleLog($event, $queueName);
            } catch (\Throwable $error) {
                // $this->handleConsumptionError($envelope, $queue);

                throw $error;
            }

            $msg->ack();
        };
    }

    private function deserializeDomainEvent(AMQPMessage $msg): DomainEvent
    {
        $this->msg = $msg;

        $eventData = JSON::decode($msg->getBody());

        $eventName = $eventData['id'];
        
        $eventClass = $this->getHeader(RabbitMQEventBus::EVENT_CLASS_KEY);

        if (null === $eventClass) {
            throw new RuntimeException("The event <$eventName> doesn't exist or has no subscribers");
        }

        return $eventClass::fromPrimitives(
            $eventData['id'],
            $eventData['body'],
            $eventData['event_id'],
            $eventData['occurred_on']
        );
    }

    private function getProperty(string $key): mixed
    {
        return $this->msg->get($key);
    }

    private function getHeader(string $key): mixed
    {
        /** @var AMQPTable $headerData */
        $headerData = $this->getProperty('application_headers');
        $nativeData = $headerData->getNativeData();

        return $nativeData[$key];
    }

    private static function consoleLog(DomainEvent $event, string $queueName): void
    {
        echo PHP_EOL;
        // echo ' [::] From RabbitMQ', PHP_EOL;
        echo ' [x] On queue: ', $queueName, PHP_EOL;
        echo ' [x] Event Name: ', $event->eventName(), PHP_EOL;
        echo ' [x] Event Aggregate id: ', $event->aggregateId(), PHP_EOL;
        // echo ' [x] Event data: ', json_encode($event->data, JSON_OBJECT_AS_ARRAY), PHP_EOL;
        echo ' [x] Event event id: ', $event->eventId(), PHP_EOL;
        echo ' [x] Event occurred on: ', $event->occurredOn(), PHP_EOL;
    }
}
