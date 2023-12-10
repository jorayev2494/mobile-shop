<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Profile;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Application\Subscribers\Profile\ProfileWasCreatedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Domains\Client\Profile\Domain\Profile\Events\ProfileWasCreatedDomainEvent;

/**
 * @group order-subscriber
 * @group order-profile-subscriber
 */
class ProfileFirstNameWasChangedDomainEventSubscriberTest extends TestCase
{
    public function testEventHandler(): void
    {
        $handler = new ProfileWasCreatedDomainEventSubscriber(
            $clientRepository = $this->createMock(ClientRepositoryInterface::class)
        );

        $clientRepository->expects($this->once())
            ->method('save')
            ->with(ClientFactory::make());

        $handler(
            new ProfileWasCreatedDomainEvent(
                ClientFactory::UUID,
                ClientFactory::FIRST_NAME,
                ClientFactory::LAST_NAME,
                ClientFactory::EMAIL,
                ClientFactory::PHONE,
            )
        );
    }
}
