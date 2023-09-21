<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\RefreshToken;

use App\Models\Enums\AppGuardType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\TokenGeneratorInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly TokenGeneratorInterface $tokenGenerator,
    )
    {
        
    }

    public function __invoke(Command $command): array
    {
        $this->authenticationService->invalidate(AppGuardType::CLIENT);
        $foundDevice = $this->deviceRepository->findByRefreshToken($command->refreshToken);

        if ($foundDevice === null) {
            throw new ModelNotFoundException();
        }

        $member = $this->repository->findByUuid($foundDevice->getAuthor()->getUuid());

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        $token = $this->authenticationService->authenticateByUuid($member->getUuid(), AppGuardType::CLIENT);

        $foundDevice->setRefreshToken($this->tokenGenerator->generate());
        $member->addDevice($foundDevice);

        $this->repository->save($member);

        return $this->authenticationService->authToken($token, $member, $foundDevice);
    }
}
