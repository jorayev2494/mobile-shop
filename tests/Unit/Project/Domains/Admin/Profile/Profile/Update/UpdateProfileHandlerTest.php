<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Profile\Profile\Update;

use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Profile\Application\Commands\Update\Command;
use Project\Domains\Admin\Profile\Application\Commands\Update\CommandHandler;
use Project\Domains\Admin\Profile\Domain\Avatar\Avatar;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Tests\Unit\Project\Domains\Admin\Profile\Profile\ProfileFactory;

class UpdateProfileHandlerTest extends TestCase
{
    // private string $avatarPath;

    // public function setUp(): void
    // {
    //     parent::setUp();
    //     // $this->avatarPath = app(); // ->storagePath();
    //     // dd($this->avatarPath);
    //     dd(
    //         app(),
    //         // Filesystem
    //     );
    // }

    public function testUpdateProfile(): void
    {
        $handler = new CommandHandler(
            $profileRepository = $this->createMock(ProfileRepositoryInterface::class),
            $filesystem = $this->createMock(FilesystemInterface::class),
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

        $handler(
            new Command(
                ProfileFactory::UUID,
                'Cat',
                'Catov',
                'cat@gmail.com',
                null,
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
            $filesystem = $this->createMock(FilesystemInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $filesystem->expects($this->once())
                ->method('deleteFile')
                ->with(null);

        $filesystem->expects($this->once())
                ->method('uploadFile')
                ->willReturn($uploadedAvatarStub = $this->createStub(Avatar::class));

        $profileStub = $this->createStub(Profile::class);
        
        $profileStub->expects($this->once())->method('getAvatar')->willReturn(null);
        $profileStub->expects($this->once())->method('deleteAvatar');
        $profileStub->expects($this->once())->method('changeAvatar')->with($uploadedAvatarStub);

        // $profileStub->expects($this->once())->method('record');

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
