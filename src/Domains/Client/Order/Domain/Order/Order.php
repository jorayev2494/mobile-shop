<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Order;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Order\Events\OrderStatusWasChangedDomainEvent;
use Project\Domains\Client\Order\Domain\Order\Events\OrderWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\AuthorUuid;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\NoteType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\EmailType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\PhoneType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\StatusType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\UuidType;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Order\Types\AuthorUuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'order_orders')]
class Order extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AuthorUuid $authorUuid;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn('author_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Client $author;

    #[ORM\Column(type: EmailType::NAME)]
    private Email $email;

    #[ORM\Column(type: PhoneType::NAME)]
    private Phone $phone;

    #[ORM\OneToMany(targetEntity: OrderProduct::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    private Collection $orderProducts;

    #[ORM\Column(type: NoteType::NAME, nullable: true)]
    private Note $note;

    // #[ORM\Column(type: CardUuidType::NAME)]
    // private CardUuid $cardUuid;

    #[ORM\ManyToOne(targetEntity: Card::class, inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'card_uuid', referencedColumnName: 'uuid')]
    private Card $card;

    // #[ORM\Column(type: AddressUuidType::NAME)]
    // private AddressUuid $addressUuid;

    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'address_uuid', referencedColumnName: 'uuid')]
    private Address $address;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'orders', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'currency_uuid', referencedColumnName: 'uuid')]
    private Currency $currency;

    #[ORM\Column(type: StatusType::NAME)]
    private StatusEnum $status;

    #[ORM\Embedded(class: Meta::class, columnPrefix: 'meta_')]
    private ?Meta $meta;

    // private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        Uuid $uuid,
        Email $email,
        Phone $phone,
        Note $note,
        array $orderProducts = [],
        Meta $meta = null,
        // bool $isActive = true,
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->phone = $phone;
        $this->note = $note;
        $this->meta = $meta;

        $this->meta = $meta;
        $this->orderProducts = new ArrayCollection($orderProducts);
        $this->status = StatusEnum::PENDING;
        // $this->isActive = $isActive;
    }

    public static function create(
        Uuid $uuid,
        Email $email,
        Phone $phone,
        Note $note,
        array $orderProducts = [],
        Meta $meta = null,
    ): self {
        $order = new self($uuid, $email, $phone, $note, $orderProducts, $meta);
        $order->record(
            new OrderWasCreatedDomainEvent(
                $order->getUuid()->value,
                $order->getStatus()->value,
                // $order->getMeta()->quantity,
                // $order->getMeta()->sum,
            )
        );

        return $order;
    }

    public function addOrderProduct(OrderProduct $orderProduct): void
    {
        if ($this->orderProducts->contains($orderProduct)) {
            return;
        }

        $orderProduct->setOrder($this);
        $this->orderProducts->add($orderProduct);
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function changeStatus(StatusEnum $status): void
    {
        if ($this->status->isNotEquals($status)) {
            $this->status = $status;
            $this->record(new OrderStatusWasChangedDomainEvent($this->uuid->value, $this->status->value));
        }
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function getAuthor(): Client
    {
        return $this->author;
    }

    public function setAuthor(Client $author): void
    {
        $this->author = $author;
    }

    public function getCard(): Card
    {
        return $this->card;
    }

    public function setCard(Card $card): void
    {
        $this->card = $card;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    #[ORM\PrePersist]
    public function prePersisting(PrePersistEventArgs $eventArgs): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdating(PreUpdateEventArgs $eventArgs): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function toArray(): array
    {
        $products = $this->orderProducts->map(static fn (Arrayable $op): array => $op->toArray());

        return [
            'uuid' => $this->uuid->value,
            'author' => $this->author->toArray(),
            'email' => $this->email->value,
            'phone' => $this->phone->value,
            'note' => $this->note->value,
            'card' => $this->card->toArray(),
            'address' => $this->address->toArray(),
            'status' => $this->status->value,
            'products' => $products->toArray(),
            'meta' => $this->meta->toArray(),
            'currency' => $this->currency->toArray(),
            // 'is_active' => $this->isActive,
            // 'created_at' => $this->createdAt?->getTimestamp(),
            // 'updated_at' => $this->updatedAt?->getTimestamp(),
        ];
    }
}
