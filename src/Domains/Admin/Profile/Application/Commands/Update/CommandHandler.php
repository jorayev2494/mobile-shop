<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileAvatar;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $profile = $this->repository->findByUuid($this->authManager->uuid());

        if ($profile === null) {
            throw new ModelNotFoundException();
        }

        $profile->changeFirstName(ProfileFirstName::fromValue($command->firstName));
        $profile->changeLastName(ProfileLastName::fromValue($command->lastName));
        $profile->changeEmail(ProfileEmail::fromValue($command->email));
        $profile->changeAvatar(ProfileAvatar::fromValue($command->avatar));
        $profile->changePhone(ProfilePhone::fromValue($command->phone));

        $this->repository->save($profile);
        $this->eventBus->publish(...$profile->pullDomainEvents());
    }

    // private function uploadAvatar(Profile $profile, ?UploadedFile $avatar): ?string
    // {
    //     if ($avatar !== null) {
    //         /** @var File $avatar */
    //         if (($avatar = $authModel->avatar) !== null) {
    //             $this->filesystem->deleteFile($authModel->avatarPath(), $avatar->name);
    //             $avatar->delete();
    //         }
    //         $avatar = $this->filesystem->uploadFile($authModel->avatarPath(), $data->avatar);
    //         $authModel->avatar()->save($avatar);
    //     }
    // }
}
