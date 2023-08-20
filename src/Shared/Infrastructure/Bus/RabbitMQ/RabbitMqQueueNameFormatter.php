<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Command\CommandInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Utils\Str;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventSubscriberInterface|CommandInterface|CommandHandlerInterface|DomainEvent $subscriber): string
    {
        return self::formatFromClassName($subscriber::class);
    }

    public static function formatFromClassName(string $className): string
    {
        $queueName = explode('\\', str_replace(['\\', 'Project.Domains.'], ['.', ''], $className));

        return implode('.', map(self::toCamelCase(), $queueName));
    }

    public static function formatRetry(DomainEventSubscriberInterface|CommandHandlerInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    public static function formatDeadLetter(DomainEventSubscriberInterface|CommandHandlerInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }

    public static function shortFormat(DomainEventSubscriberInterface|CommandHandlerInterface $subscriber): string
    {
        $subscriberCamelCaseName = (string) last(explode('\\', $subscriber::class));

        return Str::toSnakeCase($subscriberCamelCaseName);
    }

    private static function toSnakeCase(): callable
    {
        return static fn (string $text) => Str::toSnakeCase($text);
    }

    private static function toCamelCase(): callable
    {
        return static fn (string $text) => ucfirst(Str::toCamelCase($text));
    }
}
