<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RefreshToken;

use App\Models\Enums\AppGuardType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Shared\Domain\Authenticator\AuthenticatorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\TokenGeneratorInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
        private readonly AuthenticatorInterface $authenticator,
        private readonly TokenGeneratorInterface $tokenGenerator,
    )
    {
        
    }

    public function __invoke(Command $command): array
    {
        $this->authenticator->invalidate(AppGuardType::ADMIN);
        $foundDevice = $this->deviceRepository->findByRefreshToken($command->refreshToken);

        if ($foundDevice === null) {
            throw new ModelNotFoundException();
        }

        $member = $this->repository->findByUuid($foundDevice->getAuthor()->getUuid());

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        $token = $this->authenticator->loginByUuid($member->getUuid(), AppGuardType::ADMIN);

        $foundDevice->setRefreshToken($this->tokenGenerator->generate());
        $member->addDevice($foundDevice);

        $this->repository->save($member);

        return $this->authenticator->authToken($token, $member, $foundDevice);
    }
}
