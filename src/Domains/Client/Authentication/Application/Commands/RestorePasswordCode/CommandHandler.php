<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode;

use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\CodeGeneratorInterface;
use Project\Shared\Domain\DomainException;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly CodeGeneratorInterface $codeGenerator,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $member = $this->repository->findByEmail($command->email);

        $member ?? throw new DomainException('Member not found', 404);

        $member->addCode(Code::fromPrimitives($this->codeGenerator->generate(), new \DateTimeImmutable('+ 1 hour')));

        $this->repository->save($member);
        $this->eventBus->publish(...$member->pullDomainEvents());
    }
}
