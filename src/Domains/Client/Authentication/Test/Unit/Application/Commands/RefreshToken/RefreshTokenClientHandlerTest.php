<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\RefreshToken;

use App\Models\Enums\AppGuardType;
use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\RefreshToken\Command;
use Project\Domains\Client\Authentication\Application\Commands\RefreshToken\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Device\Device;
use Project\Domains\Client\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Test\Unit\Application\DeviceFactory;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Shared\Domain\DomainException;
use Project\Shared\Domain\TokenGeneratorInterface;

/**
 * @group client-auth
 * @group client-auth-application
 */
class RefreshTokenClientHandlerTest extends TestCase
{
    public function testRefreshToken(): void
    {
        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $deviceRepository = $this->createMock(DeviceRepositoryInterface::class),
            $authenticationService = $this->createMock(AuthenticationServiceInterface::class),
            $tokenGenerator = $this->createMock(TokenGeneratorInterface::class),
        );

        $tokenGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($generatedRefreshToken = 'new-refresh-token'));

        $device = $this->createMock(Device::class);
        $member = $this->createMock(Member::class);

        $device->expects($this->exactly(4))
            ->method('getAuthor')
            ->will($this->returnValue($member));

        $deviceRepository->expects($this->once())
            ->method('findByRefreshToken')
            ->with(DeviceFactory::REFRESH_TOKEN)
            ->will($this->returnValue($device));

        $authenticationService->expects($this->once())
            ->method('authenticateByUuid')
            ->with(MemberFactory::UUID, AppGuardType::CLIENT)
            ->will($this->returnValue($accessToken = 'auth_access_token'));

        $member->expects($this->once())
            ->method('getUuid')
            ->will($this->returnValue(MemberFactory::UUID));

        $member->expects($this->once())
            ->method('addDevice')
            ->with($device);

        $memberRepository->expects($this->once())
            ->method('save')
            ->with($member);

        $authenticationService->expects($this->once())
            ->method('authToken')
            ->with($accessToken, $member, $device)
            ->will($this->returnValue(
                $authToken = [
                    'access_token' => $accessToken,
                    'token_type' => 'bearer',
                    'refresh_token' => $generatedRefreshToken,
                    'expires_in' => 7200,
                    'auth_data' => MemberFactory::make()->toArray(),
                ]
            ));

        $result = $handler(
            new Command(DeviceFactory::REFRESH_TOKEN, DeviceFactory::DEVICE_ID)
        );

        $this->assertEquals(
            $authToken,
            $result
        );
    }

    public function testRefreshTokenNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Refresh token is invalid');

        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $deviceRepository = $this->createMock(DeviceRepositoryInterface::class),
            $authenticationService = $this->createMock(AuthenticationServiceInterface::class),
            $tokenGenerator = $this->createMock(TokenGeneratorInterface::class),
        );

        $tokenGenerator->expects($this->never())
            ->method('generate')
            ->will($this->returnValue($generatedRefreshToken = DeviceFactory::REFRESH_TOKEN));

        $device = $this->createMock(Device::class);
        $member = $this->createMock(Member::class);

        $device->expects($this->never())
            ->method('getAuthor')
            ->will($this->returnValue($member));

        $deviceRepository->expects($this->once())
            ->method('findByRefreshToken')
            ->with(DeviceFactory::REFRESH_TOKEN)
            ->willReturn(null);

        $accessToken = 'auth_access_token';
        $authenticationService->expects($this->never())
            ->method('authenticateByUuid')
            ->with(MemberFactory::UUID, AppGuardType::CLIENT)
            ->will($this->returnValue($accessToken));

        $member->expects($this->never())
            ->method('getUuid')
            ->will($this->returnValue(MemberFactory::UUID));

        $member->expects($this->never())
            ->method('addDevice')
            ->with($device);

        $memberRepository->expects($this->never())
            ->method('save')
            ->with($member);

        $authenticationService->expects($this->never())
            ->method('authToken')
            ->with($accessToken, $member, $device)
            ->will($this->returnValue(
                $authToken = [
                    'access_token' => $accessToken,
                    'token_type' => 'bearer',
                    'refresh_token' => $generatedRefreshToken,
                    'expires_in' => 7200,
                    'auth_data' => MemberFactory::make()->toArray(),
                ]
            ));

        $handler(
            new Command(
                DeviceFactory::REFRESH_TOKEN,
                DeviceFactory::DEVICE_ID,
            )
        );
    }
}
