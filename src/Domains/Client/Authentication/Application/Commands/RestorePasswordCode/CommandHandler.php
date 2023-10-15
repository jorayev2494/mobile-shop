<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\CodeGeneratorInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly CodeRepositoryInterface $codeRepository,
        private readonly CodeGeneratorInterface $codeGenerator,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $member = $this->repository->findByEmail($command->email);

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        $code = Code::create($this->codeGenerator->generate(), new \DateTimeImmutable('+ 1 hour'));
        $member->addCode($code);

        $this->repository->save($member);
        $this->eventBus->publish(...$code->pullDomainEvents(), ...$member->pullDomainEvents());
    }
}
