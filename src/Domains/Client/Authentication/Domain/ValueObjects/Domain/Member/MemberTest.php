<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\ValueObjects\Domain\Member;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Domain\Events\DeviceWasRemovedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasAddedDeviceDomainEvent;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Test\Unit\Application\DeviceFactory;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group client-auth
 * @group client-auth-domain
 */
class MemberTest extends TestCase
{

    private Member $member;

    protected function setUp(): void
    {
        $this->member = MemberFactory::make();
    }

    public function testCreateMember(): void
    {
        $member = Member::create(
            MemberFactory::UUID,
            MemberFactory::EMAIL,
            MemberFactory::PASSWORD,
        );

        $this->assertNotNull($member);
        $this->assertInstanceOf(Member::class, $member);
        $this->assertInstanceOf(AggregateRoot::class, $member);

        $this->assertIsString($member->getUuid());
        $this->assertSame(MemberFactory::UUID, $member->getUuid());
        $this->assertSame(MemberFactory::EMAIL, $member->getEmail());
        $this->assertEmpty($devices = $member->getDevices());
        $this->assertCount(0, $devices);

        $this->assertCount(1, $domainEvents = $member->pullDomainEvents());
        $this->assertInstanceOf(MemberWasRegisteredDomainEvent::class, $domainEvents[0]);
    }

    public function testFromPrimitives(): void
    {
        $member = Member::fromPrimitives(
            MemberFactory::UUID,
            MemberFactory::EMAIL,
            MemberFactory::PASSWORD,
        );

        $this->assertNotNull($member);
        $this->assertInstanceOf(Member::class, $member);
        $this->assertInstanceOf(AggregateRoot::class, $member);

        $this->assertIsString($member->getUuid());
        $this->assertSame(MemberFactory::UUID, $member->getUuid());
        $this->assertSame(MemberFactory::EMAIL, $member->getEmail());
        $this->assertEmpty($devices = $member->getDevices());
        $this->assertCount(0, $devices);

        $this->assertCount(0, $member->pullDomainEvents());
    }

    public function testMemberSetEmail(): void
    {
        $this->assertSame(MemberFactory::EMAIL, $this->member->getEmail());

        $this->member->setEmail('changeEmail@gmail.com');

        $this->assertNotSame(MemberFactory::EMAIL, $this->member->getEmail());
        $this->assertSame('changeEmail@gmail.com', $this->member->getEmail());

        $this->assertCount(0, $this->member->pullDomainEvents());
    }

    public function testMemberAddDevice(): void
    {
         $this->assertCount(0, $this->member->getDevices());

        $this->member->addDevice($device = DeviceFactory::make());

        $this->assertCount(1, $this->member->getDevices());
        $this->assertContainsEquals($device, $this->member->getDevices());

        $this->assertCount(1, $domainEvents = $this->member->pullDomainEvents());
        $this->assertContainsOnlyInstancesOf(MemberWasAddedDeviceDomainEvent::class, $domainEvents);
    }

    public function testMemberRemoveDevice(): void
    {
        $this->member->addDevice($device = DeviceFactory::make());

        $this->assertCount(1, $this->member->getDevices());
        $this->assertContainsEquals($device, $this->member->getDevices());

        $this->member->removeDevice($device);

        $this->assertCount(0, $this->member->getDevices());
        $this->assertNotContainsEquals($device, $this->member->getDevices());

        $this->assertCount(2, $domainEvents = $this->member->pullDomainEvents());
        $this->assertInstanceOf(MemberWasAddedDeviceDomainEvent::class, $domainEvents[0]);
        $this->assertInstanceOf(DeviceWasRemovedDomainEvent::class, $domainEvents[1]);
    }
}
