<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Logout;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Shared\Domain\Authenticator\AuthenticatorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\AppGuard;
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
        if (! $this->authManager->check(AppGuardType::CLIENT)) {
            return;
        }

        $member = $this->repository->findByUuid($this->authManager->client()->uuid);
        $device = $this->deviceRepository->findByAuthorUuidAndDeviceId($this->authManager->client()->uuid, $command->deviceId);
        
        if ($device === null) {
            return;
        }

        $member->removeDevice($device);
        $this->repository->save($member);
        $this->authenticator->logout(AppGuardType::CLIENT);
    }
}
