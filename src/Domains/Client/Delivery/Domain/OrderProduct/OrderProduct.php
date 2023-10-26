<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\OrderProduct;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Delivery\Domain\Order\Order;
use Project\Domains\Client\Delivery\Domain\OrderProduct\ValueObjects\Quantity;
use Project\Domains\Client\Delivery\Domain\Product\Product;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\OrderProduct\Types\QuantityType;

#[ORM\Entity]
#[ORM\Table(name: 'delivery_orders_products')]
class OrderProduct implements Arrayable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderProduct', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'order_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Order $order;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'cartProduct', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Product $product;

    #[ORM\Column(type: QuantityType::NAME)]
    private Quantity $quantity;

    private function __construct(Product $product, Quantity $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function create(Product $product, Quantity $quantity): self
    {
        return new self($product, $quantity);
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getProduct(): Product
    {
        return $this->product;
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
