<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\RabbitMQ;

use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Utils\Str;
use function Lambdish\Phunctional\map;

final class RabbitMqQueueNameFormatter
{
    public static function format(DomainEventSubscriberInterface $subscriber): string
    {
        $subscriberClassPaths = explode('\\', str_replace('admin', 'admin', $subscriber::class));

        $queueNameParts = [
            $subscriberClassPaths[0],
            $subscriberClassPaths[1],
            $subscriberClassPaths[2],
            last($subscriberClassPaths),
        ];

        return implode('.', map(self::toSnakeCase(), $queueNameParts));
    }

    public static function formatRetry(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "retry.$queueName";
    }

    public static function formatDeadLetter(DomainEventSubscriberInterface $subscriber): string
    {
        $queueName = self::format($subscriber);

        return "dead_letter.$queueName";
    }

    public static function shortFormat(DomainEventSubscriberInterface $subscriber): string
    {
        $subscriberCamelCaseName = (string) last(explode('\\', $subscriber::class));

        return Str::toSnakeCase($subscriberCamelCaseName);
    }

    private static function toSnakeCase(): callable
    {
        return static fn (string $text) => Str::toSnakeCase($text);
    }
}
