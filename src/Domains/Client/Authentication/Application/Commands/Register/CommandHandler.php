<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\Register;

use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command)
    {
        $foundMember = $this->repository->findByEmail($command->email);

        if ($foundMember !== null) {
            throw new DomainException('Member already exists!');
        }

        $member = Member::create(
            $this->uuidGenerator->generate(),
            $command->firstName,
            $command->lastName,
            $command->email,
            $this->passwordHasher->hash($command->password)
        );

        $this->repository->save($member);
        $this->eventBus->publish(...$member->pullDomainEvents());        
    }
}
