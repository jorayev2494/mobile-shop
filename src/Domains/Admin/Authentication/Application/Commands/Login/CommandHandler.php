<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Login;

use App\Models\Enums\AppGuardType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Device\Device;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Shared\Domain\Authenticator\AuthenticatorInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\TokenGeneratorInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Shared\Infrastructure\Authenticator\AuthenticateCredentialDTO;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly DeviceRepositoryInterface $deviceRepository,
        private readonly AuthenticatorInterface $authenticator,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly TokenGeneratorInterface $tokenGenerator,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): array
    {
        $foundMember = $this->repository->findByEmail($command->email);

        if ($foundMember === null) {
            throw new ModelNotFoundException();
        }

        $token = $this->authenticator->login(new AuthenticateCredentialDTO($command->email, $command->password), AppGuardType::ADMIN);
        
        $foundDevice = $this->deviceRepository->findByAuthorUuidAndDeviceId($foundMember->getUuid(), $command->deviceId);

        $newDevice = Device::create(
            $this->uuidGenerator->generate(),
            $this->tokenGenerator->generate(),
            $command->deviceId
        );

        $foundMember->addDevice($newDevice);

        if ($foundDevice !== null) {
            $this->deviceRepository->delete($foundDevice);
        }
        $this->repository->save($foundMember);
        $this->eventBus->publish(...$foundMember->pullDomainEvents());

        return $this->authenticator->authToken($token, $foundMember, $newDevice);
    }
}
