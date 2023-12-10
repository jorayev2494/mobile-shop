<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Services\Avatar;

use App\Models\Admin;
use App\Models\Auth\AppAuth;
use Illuminate\Http\UploadedFile;
use Project\Infrastructure\Services\Avatar\AvatarableInterface;
use Project\Infrastructure\Services\Avatar\AvatarInterface;
use Project\Infrastructure\Services\Avatar\AvatarServiceInterface;
use Project\Shared\Domain\FilesystemInterface;

class AvatarService implements AvatarServiceInterface
{
    public function __construct(
        private readonly FilesystemInterface $filesystem,
    )
    {

    }

    public function update(AvatarableInterface $entity, ?UploadedFile $avatar): void
    {
        $this->delete($entity);
        $entity->changeAvatar($this->upload($avatar));
    }

    private function upload(?UploadedFile $avatar): ?AvatarInterface
    {
        if ($avatar === null) {
            return null;
        }

        /** @var AvatarInterface $result */
        $result = $this->filesystem->uploadFile($this->getAvatarClassName(), $avatar);

        return $result;
    }

    public function delete(AvatarableInterface $entity): void
    {
        $entity->deleteAvatar();
    }

    private function getAvatarClassName(): string
    {
        return AppAuth::model() instanceof Admin ? \Project\Domains\Admin\Profile\Domain\Avatar\Avatar::class
                                                : \Project\Domains\Client\Profile\Domain\Avatar\Avatar::class;
    }
}
