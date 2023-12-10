<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Infrastructure\Services\Avatar\AvatarServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        Private readonly AvatarServiceInterface $avatarService,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $profile = $this->repository->findByUuid($command->uuid);

        if ($profile === null) {
            throw new ModelNotFoundException();
        }

        $this->avatarService->update($profile, $command->avatar);

        $profile->changeFirstName(ProfileFirstName::fromValue($command->firstName));
        $profile->changeLastName(ProfileLastName::fromValue($command->lastName));
        $profile->changeEmail(ProfileEmail::fromValue($command->email));
        $profile->changePhone(ProfilePhone::fromValue($command->phone));

        $this->repository->save($profile);
        $this->eventBus->publish(...$profile->pullDomainEvents());
    }
}
