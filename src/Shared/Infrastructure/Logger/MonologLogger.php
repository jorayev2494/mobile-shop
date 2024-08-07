<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Logger;

use Project\Shared\Domain\LoggerInterface;

final class MonologLogger implements LoggerInterface
{
    public function __construct(
        private readonly \Monolog\Logger $logger,
    )
    {
    }

    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}