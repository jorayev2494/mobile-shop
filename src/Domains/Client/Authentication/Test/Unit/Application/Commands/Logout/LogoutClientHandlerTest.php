<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\Logout;

use App\Models\Enums\AppGuardType;
use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\Logout\Command;
use Project\Domains\Client\Authentication\Application\Commands\Logout\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Test\Unit\Application\DeviceFactory;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

/**
 * @group client-auth
 * @group client-auth-application
 */
class LogoutClientHandlerTest extends TestCase
{

    // private CommandHandler $handler;

    private MemberRepositoryInterface $memberRepository;

    private DeviceRepositoryInterface $deviceRepository;

    private AuthManagerInterface $authManager;

    private AuthenticationServiceInterface $authenticationService;

    protected function setUp(): void
    {
//        $this->handler = new CommandHandler(
//            $this->memberRepository = $this->createMock(MemberRepositoryInterface::class),
//            $this->deviceRepository =$this->createMock(DeviceRepositoryInterface::class),
//            $this->authManager = $this->createMock(AuthManagerInterface::class),
//            $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class),
//        );
    }

    public function testClientSuccessLogout(): void
    {
        $handler = new CommandHandler(
            $this->memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $this->deviceRepository =$this->createMock(DeviceRepositoryInterface::class),
            $this->authManager = $this->createMock(AuthManagerInterface::class),
            $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class),
        );

        $this->authManager->expects($this->once())
            ->method('check')
            ->with(AppGuardType::CLIENT)
            ->willReturn(true);

        $member = $this->createMock(Member::class);

        $member->expects($this->any())
            ->method('getUuid')
            ->will($this->returnValue(MemberFactory::UUID));

        $this->authManager->expects($this->once())
            ->method('client')
            ->will($this->returnValue($member));

        $this->deviceRepository->expects($this->once())
            ->method('findByAuthorUuidAndDeviceId')
            ->with(MemberFactory::UUID, DeviceFactory::DEVICE_ID)
            ->will($this->returnValue($device = DeviceFactory::make()));

        $member->expects($this->once())
            ->method('removeDevice')
            ->with($device);

        $this->memberRepository->expects($this->once())
            ->method('save')
            ->with($member);

        $this->authenticationService->expects($this->once())
            ->method('logout')
            ->with(AppGuardType::CLIENT);

        $handler(
            new Command(DeviceFactory::DEVICE_ID)
        );
    }

    public function testClientAlreadyLogauted(): void
    {
        $handler = new CommandHandler(
            $this->memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $this->deviceRepository =$this->createMock(DeviceRepositoryInterface::class),
            $this->authManager = $this->createMock(AuthManagerInterface::class),
            $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class),
        );

        $this->authManager->expects($this->once())
            ->method('check')
            ->with(AppGuardType::CLIENT)
            ->willReturn(false);

        $member = $this->createMock(Member::class);

        $member->expects($this->never())
            ->method('getUuid')
            ->will($this->returnValue(MemberFactory::UUID));

        $this->authManager->expects($this->never())
            ->method('client')
            ->will($this->returnValue($member));

        $this->deviceRepository->expects($this->never())
            ->method('findByAuthorUuidAndDeviceId')
            ->with(MemberFactory::UUID, DeviceFactory::DEVICE_ID)
            ->will($this->returnValue($device = DeviceFactory::make()));

        $member->expects($this->never())
            ->method('removeDevice')
            ->with($device);

        $this->memberRepository->expects($this->never())
            ->method('save')
            ->with($member);

        $this->authenticationService->expects($this->never())
            ->method('logout')
            ->with(AppGuardType::CLIENT);

        $handler(
            new Command(DeviceFactory::DEVICE_ID)
        );
    }

    public function testClientDeviceNotFound(): void
    {
        $handler = new CommandHandler(
            $this->memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $this->deviceRepository =$this->createMock(DeviceRepositoryInterface::class),
            $this->authManager = $this->createMock(AuthManagerInterface::class),
            $this->authenticationService = $this->createMock(AuthenticationServiceInterface::class),
        );

        $this->authManager->expects($this->once())
            ->method('check')
            ->with(AppGuardType::CLIENT)
            ->willReturn(true);

        $member = $this->createMock(Member::class);

        $member->expects($this->once())
            ->method('getUuid')
            ->will($this->returnValue(MemberFactory::UUID));

        $this->authManager->expects($this->once())
            ->method('client')
            ->will($this->returnValue($member));

        $this->deviceRepository->expects($this->once())
            ->method('findByAuthorUuidAndDeviceId')
            ->with(MemberFactory::UUID, DeviceFactory::DEVICE_ID)
            ->willReturn(null);

        $member->expects($this->never())
            ->method('removeDevice')
            ->withAnyParameters();

        $this->memberRepository->expects($this->never())
            ->method('save')
            ->with($member);

        $this->authenticationService->expects($this->never())
            ->method('logout')
            ->with(AppGuardType::CLIENT);

        $handler(
            new Command(DeviceFactory::DEVICE_ID)
        );
    }
}
