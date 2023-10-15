<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Wire\AMQPTable;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Project\Shared\Infrastructure\Bus\RabbitMQ\RabbitMqQueueNameFormatter;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\QueueName;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Traits\RoutingKey;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

final class RabbitMQCommandBus implements CommandBusInterface
{
    use RoutingKey;
    use QueueName;

    public const COMMAND_CLASS_KEY = 'command_class';

    private readonly AMQPChannel $channel;

    private array $properties = [];

    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
    ) {
        $this->channel = $amqpConnection->channel();
    }

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->publishCommand($command);
        } catch (NoHandlerForMessageException) {
            // TODO optionally throw exception or not
        }
    }

    private function publishCommand(CommandInterface $command): void
    {
        $queueName = RabbitMqQueueNameFormatter::format($command);
        // $messageId = $event->eventId();
        $routingKey = $this->makeRoutingKey($queueName, $command);
        $body = $this->serializeCommand($command);

        $this->setProperties([
            // 'message_id'            => $messageId,
            'content_type'          => 'application/json',
            'content_encoding'      => 'utf-8',
        ]);

        $this->setHeader([
            self::COMMAND_CLASS_KEY   => $command::class,
        ]);

        $msg = new AMQPMessage($body, $this->getProperties());
        // https://www.cloudamqp.com/blog/how-to-run-rabbitmq-with-php.html
        $this->channel->basic_publish($msg, $this->getExchangeName($command), $routingKey);
    }

    private function getExchangeName(CommandInterface $command): string
    {
        return $command instanceof CommandInterface ? 'CommandExchange' : 'EventExchange';
    }

    private function getProperties(): array
    {
        return $this->properties;
    }

    private function serializeCommand(CommandInterface $command): string
    {
        return serialize($command);
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
