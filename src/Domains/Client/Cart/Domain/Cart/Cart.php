<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Client\Cart\Domain\Cart\Events\CartWasConfirmedDomainEvent;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\OrderConfirmData;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\StatusEnum;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProduct;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\AuthorUuidType;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\StatusType;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart\Types\UuidType;
use Project\Domains\Client\Order\Application\Subscribers\Cart\CartWasConfirmedDomainEventSubscriber;

#[ORM\Entity]
#[ORM\Table('cart_carts')]
class Cart extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(name: 'author_uuid', type: AuthorUuidType::NAME)]
    private AuthorUuid $authorUuid;

    #[ORM\Column(type: StatusType::NAME)]
    private StatusEnum $status;

    /**
     * @var Collection<int, CartProduct>
     */
    #[ORM\OneToMany(targetEntity: CartProduct::class, mappedBy: 'cart', cascade: ['persist', 'remove'])]
    private Collection $cartProducts;

    #[ORM\Embedded(class: OrderConfirmData::class, columnPrefix: 'order_confirm_')]
    private OrderConfirmData $orderConfirmData;

    private function __construct(Uuid $uuid, AuthorUuid $authorUuid, array $cartProducts = [])
    {
        $this->uuid = $uuid;
        $this->authorUuid = $authorUuid;
        $this->cartProducts = new ArrayCollection($cartProducts);
        $this->status = StatusEnum::DRAFT;
    }

    public static function create(Uuid $uuid, AuthorUuid $authorUuid, array $cartProducts = []): self
    {
        $cart = new self($uuid, $authorUuid, $cartProducts);

        return $cart;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function addCartProduct(CartProduct $cartProduct): void
    {
        $cartProduct->setCart($this);
        $this->cartProducts->add($cartProduct);
    }

    /**
     * @param iterable<CartProduct> $cartProduct
     * @return void
     */
    public function addProducts(iterable $cartProducts): void
    {
        foreach ($cartProducts as $cartProduct) {
            $this->addCartProduct($cartProduct);
        }
    }

    public function removeProduct(CartProduct $cartProduct): void
    {
        if (! $this->cartProducts->contains($cartProduct)) {
            return;
        }

        $this->cartProducts->removeElement($cartProduct);
    }

    /**
     * @return iterable<int, CartProduct>
     */
    public function getCartProducts(): iterable
    {
        return $this->cartProducts->toArray();
    }

    public function isEmpty(): bool
    {
        return $this->cartProducts->isEmpty();
    }

    public function confirm(OrderConfirmData $orderConfirmData): void
    {
        $this->orderConfirmData = $orderConfirmData;
        $this->status = StatusEnum::CONFIRM;

        $event = new CartWasConfirmedDomainEvent(
            $this->uuid->value,
            $this->authorUuid->value,
            array_map(static fn (CartProduct $cartProduct): array => $cartProduct->toArray(), $this->cartProducts->toArray()),
            $this->orderConfirmData->cardUuid,
            $this->orderConfirmData->addressUuid,
            $this->orderConfirmData->currencyUuid,
            $this->orderConfirmData->email,
            $this->orderConfirmData->phone,
            $this->orderConfirmData->promoCode,
            $this->orderConfirmData->note,
        );

        $this->record($event);
        // $eventHandler = app()->make(CartWasConfirmedDomainEventSubscriber::class);
        // $eventHandler($event);
    }

    public function toArray(): array
    {
        $quantity = $sum = $sumDiscount = 0;
        $products = $this->cartProducts->map($this->calculateCart($quantity, $sum, $sumDiscount))->toArray();

        return [
            // 'status' => $this->status->value,
            'products' => $products,
            'quantity' => $quantity,
            'sum' => $sum,
            'discount_percentage' => 0,
            'discount_price' => (float) number_format($sumDiscount, 2),
        ];
    }

    private function calculateCart(int &$quantity, int &$sum, int &$sumDiscount): \Closure
    {
        return static function (CartProduct $cartProduct) use (&$quantity, &$sum, &$sumDiscount): array {
            $data = $cartProduct->toArray();

            ['quantity' => $q, 'sum' => $s, 'sum_discount' => $sDiscount] = $data;

            $quantity += $q;
            $sum += $s;
            $sumDiscount += $sDiscount;

            return $data;
        };
    }
}
