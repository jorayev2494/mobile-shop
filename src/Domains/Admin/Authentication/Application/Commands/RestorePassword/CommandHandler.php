<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Commands\RestorePassword;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\PasswordHasherInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MemberRepositoryInterface $repository,
        private readonly CodeRepositoryInterface $codeRepository,
        private readonly PasswordHasherInterface $passwordHasher,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $code = $this->codeRepository->findByToken($command->token);

        if ($code === null) {
            throw new ModelNotFoundException();
        }

        $member = $this->repository->findByUuid($code->getAuthorUuid());

        if ($member === null) {
            throw new ModelNotFoundException();
        }

        $member->changePassword($this->passwordHasher->hash($command->password));
        $this->repository->save($member);
        $this->codeRepository->delete($code);
    }
}
