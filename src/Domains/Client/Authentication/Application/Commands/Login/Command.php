<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Login;

use Project\Shared\Domain\Bus\Command\CommandInterface;
use Project\Shared\Infrastructure\Authenticator\AuthenticateCredentialDTO;

final class Command extends AuthenticateCredentialDTO implements CommandInterface
{
    public function __construct(
        string $email,
        string $password,
        public readonly string $deviceId,
    )
    {
        parent::__construct($email, $password);
    }
}
