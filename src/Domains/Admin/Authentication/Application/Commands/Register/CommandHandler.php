<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\Register;

use DomainException;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $foundMember = $this->repository->findByEmail($command->email);

        if ($foundMember !== null) {
            throw new DomainException('Member already exists!');
        }

        $newMember = Member::create(
            $this->uuidGenerator->generate(),
            $command->firstName,
            $command->lastName,
            $command->email,
            $this->passwordHasher->hash($command->password)
        );

        $this->repository->save($newMember);
        $this->eventBus->publish(...$newMember->pullDomainEvents());
    }
}
