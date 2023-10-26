<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers\Profile;

use Project\Domains\Admin\Manager\Domain\Avatar\AvatarRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfileAvatarWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ProfileAvatarWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
        private readonly AvatarRepositoryInterface $avatarRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileAvatarWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileAvatarWasDeletedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($event->uuid));
        $avatar = $this->avatarRepository->findByUuid($event->avatarUuid);

        if ($manager === null || $avatar === null) {
            return;
        }


        // if ($manager->getAvatar() !== null && $manager->getAvatar()->getUuid() === $avatar->getUuid()) {
        //     $manager->setAvatar(null);
        // }

        // $this->repository->save($manager);
        $this->avatarRepository->delete($avatar);
    }
}
