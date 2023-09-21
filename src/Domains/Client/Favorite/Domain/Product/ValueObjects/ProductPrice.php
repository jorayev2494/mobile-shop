<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Product\ValueObjects;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

#[ORM\Embeddable]
final class ProductPrice implements Arrayable
{
    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private float $value;

    #[ORM\Column('discount_percentage', type: Types::INTEGER, nullable: true)]
    private ?int $discountPercentage;

    #[ORM\Column('currency_uuid', type: Types::STRING)]
    private string $currencyUuid;

    public function __construct(float $value, ?int $discountPercentage, string $currencyUuid)
    {
        $this->value = $value;
        $this->discountPercentage = $discountPercentage;
        $this->currencyUuid = $currencyUuid;
    }

    public function isEquals(self $productPrice): bool
    {
        return $this->value === $productPrice->value && $this->discountPercentage === $productPrice->discountPercentage && $this->currencyUuid === $productPrice->currencyUuid;
    }

    public function isNotEquals(self $productPrice): bool
    {
        return $this->value !== $productPrice->value && $this->discountPercentage !== $productPrice->discountPercentage && $this->currencyUuid !== $productPrice->currencyUuid;
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'discount_percentage' => $this->discountPercentage,
            'currency_uuid' => $this->currencyUuid,
        ];
    }
}
