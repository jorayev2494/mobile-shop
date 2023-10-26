<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Order\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Order\Domain\Currency\Currency;

#[ORM\Embeddable]
final class Meta implements Arrayable
{
    #[ORM\Column(type: Types::INTEGER)]
    public readonly int $quantity;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    public readonly float $sum;

    // #[ORM\Column('currency_uuid', type: Types::STRING)]
    // public readonly string $currencyUuid;

    // #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'orders', cascade: ['persist'])]
    // #[ORM\JoinColumn(name: 'currency_uuid', referencedColumnName: 'uuid', nullable: false)]
    // public readonly Currency $currency;

    public function __construct(int $quantity, float $sum)
    {
        $this->quantity = $quantity;
        $this->sum = $sum;
        // $this->currency = $currency;
    }

    public function getDiscountPrice(): float
    {
        return 0; // (! is_null($this->sum) && $discount = $this->sum) > 0 ? ($this->quality / 100) * $discount : 0;
    }

    public function toArray(): array
    {
        return [
            'quantity' => $this->quantity,
            'sum' => $this->sum,
            'discount_sum' => $this->getDiscountPrice(),
            // 'currency' => $this->currency,
        ];
    }
}
