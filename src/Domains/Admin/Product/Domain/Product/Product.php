<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasAddedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasDeletedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductCategoryUuid;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\CategoryUuidType;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\DescriptionType;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\TitleType;
use Project\Domains\Admin\Product\Infrastructure\Doctrine\Product\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'product_products')]
class Product extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private ProductUuid $uuid;

    #[ORM\Column(type: TitleType::NAME)]
    private ProductTitle $title;

    #[ORM\Column(name: 'category_uuid', type: CategoryUuidType::NAME)]
    private ProductCategoryUuid $categoryUuid;

    #[ORM\Embedded(class: ProductPrice::class, columnPrefix: 'price_')]
    private ProductPrice $price;

    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $medias;

    #[ORM\Column(name: 'viewed_count', type: Types::INTEGER)]
    private int $viewedCount;

    #[ORM\Column(type: DescriptionType::NAME)]
    private ProductDescription $description;

    private bool $isActive;

    private function __construct(
        ProductUuid $uuid,
        ProductTitle $title,
        ProductCategoryUuid $categoryUuid,
        ProductPrice $price,
        ProductDescription $description,
        int $viewedCount = 0,
        bool $isActive = true,
    )
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->categoryUuid = $categoryUuid;
        $this->price = $price;
        $this->description = $description;
        $this->viewedCount = $viewedCount;
        $this->isActive = $isActive;
        $this->medias = new ArrayCollection();
    }

    public static function fromPrimitives(string $uuid, string $title, string $categoryUuid, ProductPrice $price, string $description, int $viewedCount, bool $isActive): self
    {
        return new self(
            ProductUUID::fromValue($uuid),
            ProductTitle::fromValue($title),
            ProductCategoryUuid::fromValue($categoryUuid),
            $price,
            ProductDescription::fromValue($description),
            $viewedCount,
            $isActive,
        );
    }

    public static function create(
        ProductUuid $uuid,
        ProductTitle $title,
        ProductCategoryUuid $categoryUuid,
        ProductPrice $price,
        ProductDescription $description,
        bool $isActive = true,
    ): self
    {
        $product = new self($uuid, $title, $categoryUuid, $price, $description, 0, $isActive);
        $product->record(new ProductWasCreatedDomainEvent($product->uuid->value, $product->toArray()));

        return $product;
    }

	public function getUuid(): ProductUuid
    {
		return $this->uuid;
	}

	public function getTitle(): ProductTitle
    {
		return $this->title;
	}
	
	public function setTitle(ProductTitle $title): void
    {
		$this->title = $title;
	}

    public function changeTitle(ProductTitle $title): void
    {
        if ($this->title->isNotEquals($title)) {
            $this->title = $title;
        }
	}

	public function getCategoryUuid(): ProductCategoryUuid
    {
		return $this->categoryUuid;
	}
	
	public function setCategoryUuid(ProductCategoryUuid $categoryUuid): void
    {
		$this->categoryUuid = $categoryUuid;
	}

    public function changeCategoryUuid(ProductCategoryUuid $categoryUuid): void
    {
        if ($this->categoryUuid->isNotEquals($categoryUuid)) {
            $this->categoryUuid = $categoryUuid;
        }
	}

	public function getPrice(): ProductPrice
    {
		return $this->price;
	}
	
	public function setPrice(ProductPrice $price): void
    {
		$this->price = $price;
	}

    public function changePrice(ProductPrice $price): void
    {
        if ($this->price->isNotEquals($price)) {
            $this->price = $price;
        }
	}

	public function getDescription(): ProductDescription
    {
		return $this->description;
	}
	
    public function setDescription(ProductDescription $description): void
    {
        $this->description = $description;
	}

	public function changeDescription(ProductDescription $description): void
    {
        if ($this->description->isNotEquals($description)) {
            $this->description = $description;
        }
	}

    public function delete(): void
    {
        $this->record(new ProductWasDeletedDomainEvent($this->uuid->value));
    }

    public function getMedias(): iterable
    {
        return $this->medias->getIterator();
    }

    public function addMedia(Media $media): void
    {
        $media->setProduct($this);
        $this->medias->add($media);
        // $this->record(new ProductMediaWasAddedDomainEvent($this->uuid->value, $media->toArray()));
    }

    public function removeMedia(Media $media): void
    {
        $this->medias->removeElement($media);
    }

    public function toArray(): array
    {
        $medias = array_map(static fn (Arrayable $media): array => $media->toArray(), $this->medias->toArray());

        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'category_uuid' => $this->categoryUuid->value,
            'price' => $this->price->toArray(),
            'medias' => $medias,
            'viewed_count' => $this->viewedCount,
            'description' => $this->description->value,
            // 'is_active' => $this->isActive,
        ];
    }
}
