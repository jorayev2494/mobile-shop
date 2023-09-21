<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Login;

use App\Models\Enums\AppGuardType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\TokenGeneratorInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Shared\Infrastructure\Services\AuthenticateService\AuthenticationCredentialsDTO;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly AuthenticationServiceInterface $authenticationService,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): array
    {
        $member = $this->repository->findByEmail($command->email);

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        $token = $this->authenticationService->authenticate(new AuthenticationCredentialsDTO($command->email, $command->password), AppGuardType::CLIENT);

        $device = Device::create($this->uuidGenerator->generate(), $this->tokenGenerator->generate(), $command->deviceId);
        $member->addDevice($device);

        $this->repository->save($member);
        $this->eventBus->publish(...$member->pullDomainEvents());

        return $this->authenticationService->authToken($token, $member, $device);
    }
}
