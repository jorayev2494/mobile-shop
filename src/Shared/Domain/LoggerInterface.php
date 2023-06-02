<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface LoggerInterface
{
    public function info(string $message, array $content = []): void;

    public function warning(string $message, array $content = []): void;

    public function critical(string $message, array $content = []): void;
}
