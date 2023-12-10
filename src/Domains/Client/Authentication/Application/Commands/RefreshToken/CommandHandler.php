<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\RefreshToken;

use App\Models\Enums\AppGuardType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\DomainException;
use Project\Shared\Domain\TokenGeneratorInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly TokenGeneratorInterface $tokenGenerator,
    ) {

    }

    public function __invoke(Command $command): array
    {
        $this->authenticationService->invalidate(AppGuardType::CLIENT);
        $foundDevice = $this->deviceRepository->findByRefreshToken($command->refreshToken);

        $foundDevice ?? throw new DomainException('Refresh token is invalid');

        $token = $this->authenticationService->authenticateByUuid($foundDevice->getAuthor()->getUuid(), AppGuardType::CLIENT);

        $foundDevice->setRefreshToken($this->tokenGenerator->generate());
        $foundDevice->getAuthor()->addDevice($foundDevice);

        $this->repository->save($foundDevice->getAuthor());

        return $this->authenticationService->authToken($token, $foundDevice->getAuthor(), $foundDevice);
    }
}
