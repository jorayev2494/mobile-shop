<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

interface MailerInterface
{
    public function send(string $to, string $text = '', string $view = null, array $data = []): void;
}
