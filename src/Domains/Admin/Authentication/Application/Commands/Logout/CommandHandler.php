<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Logout;

use App\Models\Enums\AppGuardType;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Shared\Domain\Authenticator\AuthenticatorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
        private readonly AuthManagerInterface $authManager,
        private readonly AuthenticatorInterface $authenticator,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        if (! $this->authManager->check(AppGuardType::ADMIN)) {
            return;
        }

        $member = $this->repository->findByUuid($this->authManager->uuid());
        $device = $this->deviceRepository->findByAuthorUuidAndDeviceId($this->authManager->uuid(), $command->deviceId);
        
        if ($device === null) {
            return;
        }

        $member->removeDevice($device);
        $this->deviceRepository->delete($device);
        $this->authenticator->logout(AppGuardType::ADMIN);
    }
}
