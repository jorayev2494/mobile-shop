<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

use Project\Infrastructure\Services\Authenticate\AuthenticatableInterface;

abstract class AbstractFlasher
{
    abstract public function publish(string $channel, array $data): mixed;

    public function makePrivateChannel(string $channel, AuthenticatableInterface $authenticatable): string
    {
        return sprintf('%s#%s', $channel, $authenticatable->getUuid());
    }
}
