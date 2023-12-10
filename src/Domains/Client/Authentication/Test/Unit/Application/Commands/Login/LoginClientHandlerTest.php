<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\Login;

use App\Models\Enums\AppGuardType;
use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\Login\Command;
use Project\Domains\Client\Authentication\Application\Commands\Login\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Test\Unit\Application\DeviceFactory;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Infrastructure\Services\Authenticate\AuthenticationServiceInterface;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\TokenGeneratorInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Shared\Infrastructure\Services\AuthenticateService\AuthenticationCredentialsDTO;

/**
 * @group client-auth
 * @group client-auth-application
 */
class LoginClientHandlerTest extends TestCase
{
    public function testClientLogin(): void
    {
        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $uuidGenerator = $this->createMock(UuidGeneratorInterface::class),
            $tokenGenerator = $this->createMock(TokenGeneratorInterface::class),
            $authenticationService = $this->createMock(AuthenticationServiceInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $uuidGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($generatedUuid = DeviceFactory::UUID));

        $tokenGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($generatedRefreshToken = DeviceFactory::REFRESH_TOKEN));

        $member = $this->getMockBuilder(Member::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'addDevice',
            ])
            ->getMock();

        $member->expects($this->once())
            ->method('addDevice')
            ->with($device = DeviceFactory::make());

        $memberRepository->expects($this->once())
            ->method('findByEmail')
            ->with(MemberFactory::EMAIL)
            ->will($this->returnValue($member));

        $token = 'auth_access_token';
        $authenticationService->expects($this->once())
            ->method('authenticate')
            ->with(new AuthenticationCredentialsDTO(MemberFactory::EMAIL, MemberFactory::PASSWORD), AppGuardType::CLIENT)
            ->will($this->returnValue($token));

        $memberRepository->expects($this->once())
            ->method('save')
            ->with($member);

        $eventBus->expects($this->once())
            ->method('publish');

        $authenticationService->expects($this->once())
            ->method('authToken')
            ->with($token, $member, $device)
            ->will($this->returnValue(
                $authToken = [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'refresh_token' => $generatedRefreshToken,
                    'expires_in' => 7200,
                    'auth_data' => MemberFactory::make()->toArray(),
                ]
            ));

        $result = $handler(
            new Command(
                MemberFactory::EMAIL,
                MemberFactory::PASSWORD,
                DeviceFactory::DEVICE_ID,
            )
        );

        $this->assertEquals(
            $authToken,
            $result
        );
    }
}
