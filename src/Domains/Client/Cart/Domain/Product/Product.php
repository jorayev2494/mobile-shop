<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Product;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProduct;
use Project\Domains\Client\Cart\Domain\Category\Category;
use Project\Domains\Client\Cart\Domain\Media\Media;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CategoryUuid;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Description;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Price;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Title;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\CategoryUuidType;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\DescriptionType;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\TitleType;
use Project\Domains\Client\Cart\Infrastructure\Doctrine\Product\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'cart_products')]
class Product extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: TitleType::NAME)]
    private Title $title;

    // #[ORM\Column(name: 'category_uuid', type: CategoryUuidType::NAME)]
    // private CategoryUuid $categoryUuid;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'category_uuid', referencedColumnName: 'uuid')]
    private Category $category;

    #[ORM\Embedded(class: Price::class, columnPrefix: 'price_')]
    private Price $price;

    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $medias;

    // #[ManyToMany(targetEntity: Member::class, mappedBy: 'products')]
    // private Collection $members;

    #[ORM\Column(name: 'viewed_count', type: Types::INTEGER)]
    private int $viewedCount;

    #[ORM\Column(type: DescriptionType::NAME)]
    private Description $description;

    #[ORM\OneToOne(targetEntity: CartProduct::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private CartProduct $cartProduct;

    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

    private function __construct(
        Uuid $uuid,
        Title $title,
        Category $category,
        Price $price,
        Description $description,
        int $viewedCount = 0,
        bool $isActive = true,
    )
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->description = $description;
        $this->viewedCount = $viewedCount;
        $this->isActive = $isActive;
        // $this->medias = new ArrayCollection();

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public static function fromPrimitives(string $uuid, string $title, Category $category, Price $price, string $description, int $viewedCount, bool $isActive): self
    {
        return new self(
            Uuid::fromValue($uuid),
            Title::fromValue($title),
            $category,
            $price,
            Description::fromValue($description),
            $viewedCount,
            $isActive,
        );
    }

    public static function create(
        Uuid $uuid,
        Title $title,
        Category $category,
        Price $price,
        Description $description,
        bool $isActive = true,
    ): self
    {
        $product = new self($uuid, $title, $category, $price, $description, 0, $isActive);

        return $product;
    }

	public function getUuid(): Uuid
    {
		return $this->uuid;
	}

	public function getTitle(): Title
    {
		return $this->title;
	}
	
	public function setTitle(Title $title): void
    {
		$this->title = $title;
	}

    public function changeTitle(Title $title): void
    {
        if ($this->title->isNotEquals($title)) {
            $this->title = $title;
        }
	}

	// public function getCategoryUuid(): CategoryUuid
    // {
	// 	return $this->categoryUuid;
	// }
	
	// public function setCategoryUuid(CategoryUuid $categoryUuid): void
    // {
	// 	$this->categoryUuid = $categoryUuid;
	// }

	public function getPrice(): Price
    {
		return $this->price;
	}
	
	public function setPrice(Price $price): void
    {
		$this->price = $price;
	}

    public function changePrice(Price $price): void
    {
        if ($this->price->isNotEquals($price)) {
            $this->price = $price;
        }
	}

	public function getDescription(): Description
    {
		return $this->description;
	}
	
    public function setDescription(Description $description): void
    {
        $this->description = $description;
	}

	public function changeDescription(Description $description): void
    {
        if ($this->description->isNotEquals($description)) {
            $this->description = $description;
        }
	}

    public function getMedias(): iterable
    {
        return $this->medias->getIterator();
    }

    public function addMedia(Media $media): void
    {
        $media->setProduct($this);
        $this->medias->add($media);
    }

    public function removeMedia(Media $media): void
    {
        $this->medias->removeElement($media);
    }

    public function getCover(): ?Media
    {
        return $this->medias->first() ?: null;
    }

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        $medias = array_map(static fn (Arrayable $media): array => $media->toArray(), $this->medias->toArray());

        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'category' => $this->category->toArray(),
            'price' => $this->price->toArray(),
            'cover' => $this->getCover()?->toArray(),
            'medias' => $medias,
            'viewed_count' => $this->viewedCount,
            'description' => $this->description->value,
            // 'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
