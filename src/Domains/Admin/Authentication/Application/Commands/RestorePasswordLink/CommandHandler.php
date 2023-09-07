<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\TokenGeneratorInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly CodeRepositoryInterface $codeRepository,
        private readonly TokenGeneratorInterface $tokenGenerator,
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

        $code = Code::create($this->tokenGenerator->generate(), new \DateTimeImmutable('+ 1 hour'));
        $member->addCode($code);

        $this->repository->save($member);
        $this->eventBus->publish(...$member->pullDomainEvents());
    }
}
