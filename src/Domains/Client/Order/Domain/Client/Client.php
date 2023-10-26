<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Client;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\LastName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\FirstName;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types\UuidType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types\EmailType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types\FirstNameType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types\LastNameType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Client\Types\PhoneType;

#[ORM\Entity]
#[ORM\Table(name: 'order_clients')]
class Client
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME)]
    private FirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME)]
    private LastName $lastName;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(type: PhoneType::NAME, nullable: true)]
    private ?Phone $phone;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $orders;

    #[ORM\OneToMany(targetEntity: Card::class, mappedBy: 'author', cascade: ['persist', 'remove'])]
    private Collection $cards;

    private function __construct(
        Uuid $uuid,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        Phone $phone,
    ) {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->orders = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public static function fromPrimitives(
        string $uuid,
        string $firstName,
        string $lastName,
        string $email,
        ?string $phone,
    ): self {
        return new self(
            Uuid::fromValue($uuid),
            FirstName::fromValue($firstName),
            LastName::fromValue($lastName),
            Email::fromValue($email),
            Phone::fromValue($phone),
        );
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function addOrder(Order $order): void
    {
        if ($this->orders->contains($order)) {
            return;
        }

        $this->orders->add($order);
        $order->setAuthor($this);
    }

    public function addCard(Card $card): void
    {
        if ($this->cards->contains($card)) {
            return;
        }

        $this->cards->add($card);
        $card->setAuthor($this);
    }

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function setFirstName(FirstName $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    public function setLastName(LastName $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'first_name' => $this->firstName->value,
            'last_name' => $this->lastName->value,
            'email' => $this->email->value,
            'phone' => $this->phone->value,
        ];
    }
}
