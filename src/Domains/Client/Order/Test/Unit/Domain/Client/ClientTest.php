<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Client;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\FirstName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\LastName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group order
 * @group order-domain
 * @group order-client-domain
 */
class ClientTest extends TestCase
{
    /**
     * @dataProvider fromPrimitivesProvider
     */
    public function testFromPrimitives(string $uuid, string $firstName, string $lastName, string $email, ?string $phone): void
    {
        $client = Client::fromPrimitives($uuid, $firstName, $lastName, $email, $phone);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertNotInstanceOf(AggregateRoot::class, $client);

        $this->assertInstanceOf(Uuid::class, $client->getUuid());
        $this->assertSame($uuid, $client->getUuid()->value);

        $this->assertInstanceOf(FirstName::class, $client->getFirstName());
        $this->assertSame($firstName, $client->getFirstName()->value);

        $this->assertInstanceOf(LastName::class, $client->getLastName());
        $this->assertSame($lastName, $client->getLastName()->value);

        $this->assertInstanceOf(Email::class, $client->getEmail());
        $this->assertSame($email, $client->getEmail()->value);

        $this->assertInstanceOf(Phone::class, $client->getPhone());
        $this->assertSame($phone, $client->getPhone()->value);
    }

    public function fromPrimitivesProvider(): array
    {
        return [
            'withAppParameters' => [
                ClientFactory::UUID,
                ClientFactory::FIRST_NAME,
                ClientFactory::LAST_NAME,
                ClientFactory::EMAIL,
                ClientFactory::PHONE,
            ],
            'withoutPhone' => [
                ClientFactory::UUID,
                ClientFactory::FIRST_NAME,
                ClientFactory::LAST_NAME,
                ClientFactory::EMAIL,
                null,
            ],
        ];
    }

    public function testClientSetFirstName(): void
    {
        $client = ClientFactory::make();

        $this->assertSame(ClientFactory::FIRST_NAME, $client->getFirstName()->value);

        $client->setFirstName(FirstName::fromValue('Oleg'));

        $this->assertInstanceOf(FirstName::class, $fName = $client->getFirstName());
        $this->assertNotSame(ClientFactory::FIRST_NAME, $fName->value);
        $this->assertNotNull($fName->value);
        $this->assertSame('Oleg', $fName->value);
    }

    public function testClientSetLastName(): void
    {
        $client = ClientFactory::make();

        $this->assertSame(ClientFactory::LAST_NAME, $client->getLastName()->value);

        $client->setLastName(LastName::fromValue('Olegov'));

        $this->assertInstanceOf(LastName::class, $lName = $client->getLastName());
        $this->assertNotSame(ClientFactory::FIRST_NAME, $lName->value);
        $this->assertNotNull($lName->value);
        $this->assertSame('Olegov', $lName->value);
    }

    public function testClientSetEmail(): void
    {
        $client = ClientFactory::make();

        $this->assertSame(ClientFactory::EMAIL, $client->getEmail()->value);

        $client->setEmail(Email::fromValue('oleg@gmail.com'));

        $this->assertInstanceOf(Email::class, $email = $client->getEmail());
        $this->assertNotSame(ClientFactory::FIRST_NAME, $email->value);
        $this->assertNotNull($email->value);
        $this->assertSame('oleg@gmail.com', $email->value);
    }

    public function testClientSetPhone(): void
    {
        $client = ClientFactory::make();

        $this->assertSame(ClientFactory::PHONE, $client->getPhone()->value);

        $client->setPhone(Phone::fromValue('1234567890'));

        $this->assertInstanceOf(Phone::class, $phone = $client->getPhone());
        $this->assertNotSame(ClientFactory::PHONE, $phone->value);
        $this->assertNotNull($phone->value);
        $this->assertSame('1234567890', $phone->value);
    }

    public function testClientSetPhoneNull(): void
    {
        $client = ClientFactory::make();

        $this->assertSame(ClientFactory::PHONE, $client->getPhone()->value);

        $client->setPhone(Phone::fromValue(null));

        $this->assertInstanceOf(Phone::class, $phone = $client->getPhone());
        $this->assertNotSame(ClientFactory::PHONE, $phone->value);
        $this->assertNull($phone->value);
    }
}
