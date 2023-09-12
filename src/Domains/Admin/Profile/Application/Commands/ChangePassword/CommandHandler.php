<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Commands\ChangePassword;

use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $admin = $this->authManager->admin();
        
        if (! $this->passwordHasher->check($command->currentPassword, $admin->password)) {
            return;
        }

        if ($command->currentPassword !== $command->password) {
            $this->authManager->admin()->updatePassword($command->password);
        }
    }
}
