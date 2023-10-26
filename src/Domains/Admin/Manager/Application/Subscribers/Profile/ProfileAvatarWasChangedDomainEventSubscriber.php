<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Subscribers\Profile;

use Project\Domains\Admin\Manager\Domain\Avatar\Avatar;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Domains\Admin\Profile\Domain\Profile\Events\ProfileAvatarWasChangedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

class ProfileAvatarWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProfileAvatarWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ProfileAvatarWasChangedDomainEvent $event): void
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($event->uuid));

        if ($manager === null) {
            return;
        }

        [
            'uuid' => $uuid,
            'mime_type' => $mimeType,
            'width' => $width,
            'height' => $height,
            'extension' => $extension,
            'size' => $size,
            'path' => $path,
            'full_path' => $fullPath,
            'file_name' => $fileName,
            'file_original_name' => $fileOriginalName,
            'url' => $url,
            'downloaded_count' => $downloadedCount,
            'url_pattern' => $urlPattern,
        ] = $event->avatar;

        $media = Avatar::make($uuid, $mimeType, $width, $height, $extension, $size, $path, $fullPath, $fileName, $fileOriginalName, $url, $downloadedCount, $urlPattern);

        $manager->setAvatar($media);

        $this->repository->save($manager);
    }
}
