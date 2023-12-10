<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Subscribers;

use Project\Domains\Admin\Profile\Domain\Avatar\AvatarRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfileAvatarWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\FilesystemInterface;

class ProfileAvatarWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    function __construct(
        private readonly AvatarRepositoryInterface $avatarRepository,
        private readonly FilesystemInterface $filesystem,
    )
    {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileAvatarWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileAvatarWasDeletedDomainEvent $event): void
    {
        $avatar = $this->avatarRepository->findByUuid($event->avatarUuid);

        if ($avatar === null) {
            return;
        }

        $this->filesystem->deleteFile($avatar);
        $this->avatarRepository->delete($avatar);
    }
}
