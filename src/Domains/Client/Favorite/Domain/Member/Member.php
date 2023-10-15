<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Member;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Favorite\Domain\Product\Product;
use Project\Domains\Client\Favorite\Infrastructure\Doctrine\Member\Types\UuidType;

#[ORM\Entity]
#[ORM\Table('favorite_member')]
final class Member implements Arrayable
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private MemberUuid $uuid;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'members', cascade: ['persist', 'remove'])]
    #[ORM\JoinTable(
        name: 'favorite_members_products',
        joinColumns: new ORM\JoinColumn(name: 'member_uuid', referencedColumnName: 'uuid', nullable: false),
        inverseJoinColumns: new ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'uuid', nullable: false)
    )]
    private Collection $products;

    public function __construct(
        MemberUuid $uuid,
    )
    {
        $this->uuid = $uuid;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): void
    {
        if ($this->products->contains($product)) {
            return;
        }

        $this->products->add($product);
    }

    public function removeProduct(Product $product): void
    {
        if (! $this->products->contains($product)) {
            return;
        }

        $this->products->removeElement($product);
    }

    public static function create(MemberUuid $uuid): self
    {
        return new self($uuid);
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
        ];
    }
}
