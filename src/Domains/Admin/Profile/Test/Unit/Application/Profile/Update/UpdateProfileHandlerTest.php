<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Test\Unit\Application\Profile\Update;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Profile\Application\Commands\Update\Command;
use Project\Domains\Admin\Profile\Application\Commands\Update\CommandHandler;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\Services\AvatarServiceInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Domains\Admin\Profile\Test\Unit\Application\ProfileFactory;

/**
 * @group admin-profile-application
 */
class UpdateProfileHandlerTest extends TestCase
{
    public function testUpdateProfile(): void
    {
        $handler = new CommandHandler(
            $profileRepository = $this->createMock(ProfileRepositoryInterface::class),
            $avatarService = $this->createMock(AvatarServiceInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $profileStub = $this->createStub(Profile::class);
        $profileStub->expects($this->once())->method('changeFirstName')->with(ProfileFirstName::fromValue('Cat'));
        $profileStub->expects($this->once())->method('changeLastName')->with(ProfileLastName::fromValue('Catov'));
        $profileStub->expects($this->once())->method('changeEmail')->with(ProfileEmail::fromValue('cat@gmail.com'));
        $profileStub->expects($this->once())->method('changePhone')->with(ProfilePhone::fromValue('123'));

        // $profileStub->expects($this->exactly(4))->method('record');

        $profileStub->expects($this->once())->method('pullDomainEvents');

        $profileRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ProfileFactory::UUID)
                        ->willReturn($profileStub);

        $profileRepository->expects($this->once())
                        ->method('save')
                        ->with($profileStub);

        $eventBus->expects($this->once())
                ->method('publish');

        $randomImageNumber = random_int(1, 15);
        $fp = getenv('PWD') . "/storage/app/public/faker/image-{$randomImageNumber}.jpg";
        $fakeAvatar = new UploadedFile($fp, "avatar-fake.png", 'image/jpeg');

        $handler(
            new Command(
                ProfileFactory::UUID,
                'Cat',
                'Catov',
                'cat@gmail.com',
                $fakeAvatar,
                '123',
            )
        );
    }

    public function testUpdateProfileAvatar(): void
    {
        $randomImageNumber = random_int(1, 15);
        $fp = getenv('PWD') . "/storage/app/public/faker/image-{$randomImageNumber}.jpg";
        $fakeAvatar = new UploadedFile($fp, "avatar-fake.png", 'image/jpeg');

        $handler = new CommandHandler(
            $profileRepository = $this->createMock(ProfileRepositoryInterface::class),
            $avatarService = $this->createMock(AvatarServiceInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $profile = $this->createStub(Profile::class);

        $avatarService->expects($this->once())
            ->method('update')
            ->with($profile, $fakeAvatar);

        $profile->expects($this->once())->method('pullDomainEvents');

        $profileRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ProfileFactory::UUID)
                        ->willReturn($profile);

        $profileRepository->expects($this->once())
                        ->method('save')
                        ->with($profile);

        $eventBus->expects($this->once())
                ->method('publish');

        $handler(
            new Command(
                ProfileFactory::UUID,
                ProfileFactory::FIRST_NAME,
                ProfileFactory::LAST_NAME,
                ProfileFactory::EMAIL,
                $fakeAvatar,
                ProfileFactory::PHONE,
            )
        );
    }
}
