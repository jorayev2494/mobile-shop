<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\CartProduct;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\CartProduct\ValueObjects\Quantity;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\CartProduct\Types\QuantityType;

#[ORM\Entity]
#[ORM\Table(name: 'cart_carts_products')]
class CartProduct implements Arrayable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\Column(type: QuantityType::NAME)]
    private Quantity $quantity;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartProduct', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'cart_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'cartProduct', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Product $product;

    private function __construct(Product $product, Quantity $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function create(Product $product, Quantity $quantity): self
    {
        return new self($product, $quantity);
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function setQuantity(Quantity $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        $sum = $this->product->getPrice()->getValue() * $this->quantity->value;
        $sumDiscountPrice = $this->product->getPrice()->getDiscountPrice() * $this->quantity->value;

        return [
            'product' => $this->product->toArray(),
            'quantity' => $this->quantity->value,
            'sum_discount' => (float) number_format($sumDiscountPrice, 2),
            'sum' => $sum,
        ];
    }
}
