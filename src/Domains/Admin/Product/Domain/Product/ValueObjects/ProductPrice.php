<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Admin\Product\Domain\Currency\Currency;

#[ORM\Embeddable]
final class ProductPrice implements Arrayable
{
    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private float $value;

    #[ORM\Column('discount_percentage', type: Types::INTEGER, nullable: true)]
    private ?int $discountPercentage;

    // #[ORM\Column('currency_uuid', type: Types::STRING)]
    // private string $currencyUuid;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'currency_uuid', referencedColumnName: 'uuid')]
    private Currency $currency;

    public function __construct(float $value, ?int $discountPercentage, Currency $currency)
    {
        $this->value = $value;
        $this->discountPercentage = $discountPercentage;
        $this->currency = $currency;
    }

    public function getDiscountPrice(): float
    {
        return (! is_null($this->discountPercentage) && $discount = $this->discountPercentage) > 0 ? ($this->value / 100) * $discount : 0;
    }

    public function isEquals(self $productPrice): bool
    {
        return $this->value === $productPrice->value && $this->discountPercentage === $productPrice->discountPercentage && $this->currency->getValue()->value === $productPrice->currency->getValue()->value;
    }

    public function isNotEquals(self $productPrice): bool
    {
        return $this->value !== $productPrice->value && $this->discountPercentage !== $productPrice->discountPercentage && $this->currency->getValue()->value !== $productPrice->currency->getValue()->value;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'discount_percentage' => $this->discountPercentage,
            // 'currency' => $this->currency->toArray(),
        ];
    }
}
