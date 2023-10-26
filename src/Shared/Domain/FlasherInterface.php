<?php

declare(strict_types= 1);

namespace Project\Shared\Domain;

interface FlasherInterface
{
    public function publish(string $channel, array $data, string $type = 'success'): mixed;
}
