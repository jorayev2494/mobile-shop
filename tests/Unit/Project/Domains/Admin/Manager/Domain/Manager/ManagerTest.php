<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Manager\Domain\Manager;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerRoleWasChangedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Tests\Unit\Project\Domains\Admin\Manager\Application\Manager\ManagerFactory;

/**
 * @group manager
 * @group manager-domain
 */
class ManagerTest extends TestCase
{
    public function testCreateManager(): void
    {
        $manager = Manager::create(
            ManagerUuid::fromValue(ManagerFactory::UUID),
            ManagerFirstName::fromValue(ManagerFactory::FIRST_NAME),
            ManagerLastName::fromValue(ManagerFactory::LAST_NAME),
            ManagerEmail::fromValue(ManagerFactory::EMAIL),
        );

        $this->assertInstanceOf(Manager::class, $manager);

        $this->assertInstanceOf(ManagerUuid::class, $manager->getUuid());
        $this->assertSame(ManagerFactory::UUID, $manager->getUuid()->value);

        $this->assertInstanceOf(ManagerFirstName::class, $manager->getFirstName());
        $this->assertSame(ManagerFactory::FIRST_NAME, $manager->getFirstName()->value);

        $this->assertInstanceOf(ManagerLastName::class, $manager->getLastName());
        $this->assertSame(ManagerFactory::LAST_NAME, $manager->getLastName()->value);

        $this->assertInstanceOf(ManagerEmail::class, $manager->getEmail());
        $this->assertSame(ManagerFactory::EMAIL, $manager->getEmail()->value);

        $this->assertCount(1, $domainEvents = $manager->pullDomainEvents());
        $this->assertInstanceOf(ManagerWasCreatedDomainEvent::class, $domainEvents[0]);
    }

    public function testCreateManagerFromPrimitives(): void
    {
        $manager = Manager::fromPrimitives(
            ManagerFactory::UUID,
            ManagerFactory::FIRST_NAME,
            ManagerFactory::LAST_NAME,
            ManagerFactory::EMAIL,
        );

        $this->assertInstanceOf(Manager::class, $manager);

        $this->assertInstanceOf(ManagerUuid::class, $manager->getUuid());
        $this->assertSame(ManagerFactory::UUID, $manager->getUuid()->value);

        $this->assertInstanceOf(ManagerFirstName::class, $manager->getFirstName());
        $this->assertSame(ManagerFactory::FIRST_NAME, $manager->getFirstName()->value);

        $this->assertInstanceOf(ManagerLastName::class, $manager->getLastName());
        $this->assertSame(ManagerFactory::LAST_NAME, $manager->getLastName()->value);

        $this->assertInstanceOf(ManagerEmail::class, $manager->getEmail());
        $this->assertSame(ManagerFactory::EMAIL, $manager->getEmail()->value);

        $this->assertCount(0, $manager->pullDomainEvents());
    }

    public function testChangeManagerFirstName(): void
    {
        $manager = ManagerFactory::make();

        $manager->changeFirstName(ManagerFirstName::fromValue('Dima'));

        $this->assertInstanceOf(ManagerFirstName::class, $manager->getFirstName());
        $this->assertSame('Dima', $manager->getFirstName()->value);

        $this->assertCount(0, $manager->pullDomainEvents());
    }

    public function testChangeManagerLastName(): void
    {
        $manager = ManagerFactory::make();

        $manager->changeLastName(ManagerLastName::fromValue('Petrov'));

        $this->assertInstanceOf(ManagerLastName::class, $manager->getLastName());
        $this->assertSame('Petrov', $manager->getLastName()->value);

        $this->assertCount(0, $manager->pullDomainEvents());
    }

    public function testChangeManagerEmail(): void
    {
        $manager = ManagerFactory::make();

        $manager->changeEmail(ManagerEmail::fromValue('dima@gmail.com'));

        $this->assertInstanceOf(ManagerEmail::class, $manager->getEmail());
        $this->assertSame('dima@gmail.com', $manager->getEmail()->value);

        $this->assertCount(0, $manager->pullDomainEvents());
    }

    public function testChangeManagerPhone(): void
    {
        $manager = ManagerFactory::make();

        $manager->changePhone(ManagerPhone::fromValue('123'));

        $this->assertInstanceOf(ManagerPhone::class, $manager->getPhone());
        $this->assertSame('123', $manager->getPhone()->value);

        $this->assertCount(0, $manager->pullDomainEvents());
    }

    public function testChangeManagerRoleId(): void
    {
        $manager = ManagerFactory::make();

        $manager->changeRoleId(10);

        $this->assertIsInt($manager->getRoleId());
        $this->assertSame(10, $manager->getRoleId());

        $this->assertCount(1, $domainEvents = $manager->pullDomainEvents());
        $this->assertInstanceOf(ManagerRoleWasChangedDomainEvent::class, $domainEvents[0]);
    }
}
