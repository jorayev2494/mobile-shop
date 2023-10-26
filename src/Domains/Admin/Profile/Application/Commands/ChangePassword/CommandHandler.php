<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Commands\ChangePassword;

use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\PasswordHasherInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly PasswordHasherInterface $passwordHasher,
    ) {

    }

    public function __invoke(Command $command): void
    {
        // $admin = $this->authManager->admin();

        // if (! $this->passwordHasher->check($command->currentPassword, $admin->password)) {
        //     return;
        // }

        // if ($command->currentPassword !== $command->password) {
        //     $this->authManager->admin()->updatePassword($command->password);
        // }
    }
}
