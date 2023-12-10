<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Card;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Test\Unit\Application\CardFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;

/**
 * @group order-domain
 * @group order-card-domain
 */
class CardTest extends TestCase
{

    private Card $card;

    protected function setUp(): void
    {
        $this->card = CardFactory::make();
    }

    public function testCreate(): void
    {
        $card = Card::create(
            Uuid::fromValue(CardFactory::UUID),
            $client = ClientFactory::make(),
            Type::fromValue(CardFactory::TYPE),
            HolderName::fromValue(CardFactory::HOLDER_NAME),
            Number::fromValue(CardFactory::NUMBER),
            CVV::fromValue(CardFactory::CVV),
            ExpirationDate::fromValue(CardFactory::EXPIRATION_DATE),
        );

        $this->assertInstanceOf(Card::class, $card);

        $this->assertInstanceOf(Uuid::class, $card->getUuid());
        $this->assertSame(CardFactory::UUID, $card->getUuid()->value);

        $this->assertInstanceOf(Client::class, $card->getAuthor());
        // $this->assertObjectEquals($client, $card->getAuthor());

        $this->assertInstanceOf(Type::class, $card->getType());
        $this->assertSame(CardFactory::TYPE, $card->getType()->value);

        $this->assertInstanceOf(HolderName::class, $card->getHolderName());
        $this->assertSame(CardFactory::HOLDER_NAME, $card->getHolderName()->value);

        $this->assertInstanceOf(Number::class, $card->getNumber());
        $this->assertSame(CardFactory::NUMBER, $card->getNumber()->value);

        $this->assertInstanceOf(CVV::class, $card->getCVV());
        $this->assertSame(CardFactory::CVV, $card->getCVV()->value);

        $this->assertInstanceOf(ExpirationDate::class, $card->getExpirationDate());
        $this->assertSame(CardFactory::EXPIRATION_DATE, $card->getExpirationDate()->value);

        $this->assertCount(0, $card->pullDomainEvents());
    }

    public function testCardChangeAuthor(): void
    {
        $this->assertNotNull($this->card->getAuthor());
        $this->assertInstanceOf(Client::class, $this->card->getAuthor());
        $this->assertSame(ClientFactory::UUID, $this->card->getAuthor()->getUuid()->value);
        $this->assertSame(ClientFactory::FIRST_NAME, $this->card->getAuthor()->getFirstName()->value);
        $this->assertSame(ClientFactory::LAST_NAME, $this->card->getAuthor()->getLastName()->value);
        $this->assertSame(ClientFactory::EMAIL, $this->card->getAuthor()->getEmail()->value);
        $this->assertSame(ClientFactory::PHONE, $this->card->getAuthor()->getPhone()->value);

        $this->card->changeAuthor(ClientFactory::make('2bc54802-a990-4e5b-9a7f-ffacb451e880', 'Alex', 'Alexeev', 'alex@gmail.com', '09877'));

        $this->assertNotNull($this->card->getAuthor());
        $this->assertInstanceOf(Client::class, $this->card->getAuthor());
        $this->assertSame('2bc54802-a990-4e5b-9a7f-ffacb451e880', $this->card->getAuthor()->getUuid()->value);
        $this->assertSame('Alex', $this->card->getAuthor()->getFirstName()->value);
        $this->assertSame('Alexeev', $this->card->getAuthor()->getLastName()->value);
        $this->assertSame('alex@gmail.com', $this->card->getAuthor()->getEmail()->value);
        $this->assertSame('09877', $this->card->getAuthor()->getPhone()->value);
    }

    public function testCardChangeType(): void
    {
        $this->assertInstanceOf(Type::class, $this->card->getType());
        $this->assertSame(CardFactory::TYPE, $this->card->getType()->value);

        $this->card->changeType(Type::fromValue('master'));

        $this->assertInstanceOf(Type::class, $this->card->getType());
        $this->assertNotSame(CardFactory::TYPE, $this->card->getType()->value);
        $this->assertSame('master', $this->card->getType()->value);
    }

    public function testCardChangeHolderName(): void
    {
        $this->assertInstanceOf(HolderName::class, $this->card->getHolderName());
        $this->assertSame(CardFactory::HOLDER_NAME, $this->card->getHolderName()->value);

        $this->card->changeHolderName(HolderName::fromValue('Alex Alexeev'));

        $this->assertInstanceOf(HolderName::class, $this->card->getHolderName());
        $this->assertNotSame(CardFactory::HOLDER_NAME, $this->card->getHolderName()->value);
        $this->assertSame('Alex Alexeev', $this->card->getHolderName()->value);
    }

    public function testCardChangeNumber(): void
    {
        $this->assertInstanceOf(Number::class, $this->card->getNumber());
        $this->assertSame(CardFactory::NUMBER, $this->card->getNumber()->value);

        $this->card->changeNumber(Number::fromValue('0000-0000-0000-0000'));

        $this->assertInstanceOf(Number::class, $this->card->getNumber());
        $this->assertNotSame(CardFactory::NUMBER, $this->card->getNumber()->value);
        $this->assertSame('0000-0000-0000-0000', $this->card->getNumber()->value);
    }

    public function testCardChangeCvv(): void
    {
        $this->assertInstanceOf(CVV::class, $this->card->getCVV());
        $this->assertSame(CardFactory::CVV, $this->card->getCVV()->value);

        $this->card->changeCVV(CVV::fromValue(567));

        $this->assertInstanceOf(CVV::class, $this->card->getCVV());
        $this->assertNotSame(CardFactory::CVV, $this->card->getCVV()->value);
        $this->assertIsInt($this->card->getCVV()->value);
        $this->assertSame(567, $this->card->getCVV()->value);
    }

    public function testCardChangeExpirationDate(): void
    {
        $this->assertInstanceOf(ExpirationDate::class, $this->card->getExpirationDate());
        $this->assertSame(CardFactory::EXPIRATION_DATE, $this->card->getExpirationDate()->value);

        $this->card->changeExpirationDate(ExpirationDate::fromValue('12/05'));

        $this->assertInstanceOf(Expirationdate::class, $this->card->getExpirationDate());
        $this->assertNotSame(CardFactory::EXPIRATION_DATE, $this->card->getExpirationDate()->value);
        $this->assertSame('12/05', $this->card->getExpirationDate()->value);
    }
}
