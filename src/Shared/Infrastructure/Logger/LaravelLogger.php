<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Logger;

use Project\Shared\Domain\LoggerInterface;

final class LaravelLogger implements LoggerInterface
{

    public function __construct(
        private readonly \Psr\Log\LoggerInterface $logger,
    )
    {
        
    }

    public function info(string $message, array $content = []): void
    {
        $this->logger->info($message, $content);
    }

    public function warning(string $message, array $content = []): void
    {
        $this->logger->warning($message, $content);
    }

    public function critical(string $message, array $content = []): void
    {
        $this->logger->warning($message, $content);
    }
}
