<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product;

use App\Models\Currency;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreUpdateEventArgs};
use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductCategoryWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductDescriptionWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasAddedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasDeletedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductPriceWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductTitleWasChangedDomainEvent;
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

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'category_uuid', referencedColumnName: 'uuid')]
    private Category $category;

    #[ORM\Embedded(class: ProductPrice::class, columnPrefix: 'price_')]
    private ProductPrice $price;

    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $medias;

    #[ORM\Column(name: 'viewed_count', type: Types::INTEGER)]
    private int $viewedCount;

    #[ORM\Column(type: DescriptionType::NAME)]
    private ProductDescription $description;

    private bool $isActive;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $updatedAt = null;

    private function __construct(
        ProductUuid $uuid,
        ProductTitle $title,
        Category $category,
        ProductPrice $price,
        ProductDescription $description,
        int $viewedCount = 0,
        bool $isActive = true,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ) {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
        $this->description = $description;
        $this->viewedCount = $viewedCount;
        $this->isActive = $isActive;
        $this->medias = new ArrayCollection();

        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function fromPrimitives(string $uuid, string $title, Category $category, ProductPrice $price, string $description, int $viewedCount, bool $isActive, DateTimeImmutable $createdAt = null, DateTimeImmutable $updatedAt = null): self
    {
        return new self(
            ProductUUID::fromValue($uuid),
            ProductTitle::fromValue($title),
            $category,
            $price,
            ProductDescription::fromValue($description),
            $viewedCount,
            $isActive,
            $createdAt,
            $updatedAt,
        );
    }

    public static function create(
        ProductUuid $uuid,
        ProductTitle $title,
        Category $category,
        ProductPrice $price,
        ProductDescription $description,
        bool $isActive = true,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): self {
        $product = new self($uuid, $title, $category, $price, $description, 0, $isActive, $createdAt, $updatedAt);

        $event = new ProductWasCreatedDomainEvent(
            $product->uuid->value,
            $product->title->value,
            $product->category->getUuid()->value,
            $product->price->toArray(),
            $product->viewedCount,
            $product->description->value,
            $product->isActive,
        );

        $product->record($event);

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
            $this->setTitle($title);
            $this->record(new ProductTitleWasChangedDomainEvent($this->getUuid()->value, $this->getTitle()->value));
        }
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function changeCategory(Category $category): void
    {
        if ($this->category->getValue()->value !== $category->getValue()->value) {
            $this->setCategory($category);
            $this->record(new ProductCategoryWasChangedDomainEvent($this->uuid->value, $this->category->getUuid()->value));
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
            $this->setPrice($price);
            $this->record(new ProductPriceWasChangedDomainEvent($this->uuid->value, $this->price->getValue()));
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
            $this->setDescription($description);
            $this->record(new ProductDescriptionWasChangedDomainEvent($this->uuid->value, $this->description->value));
        }
    }

    public function getViewedCount(): int
    {
        return $this->viewedCount;
    }

    public function delete(): void
    {
        $this->record(new ProductWasDeletedDomainEvent($this->uuid->value));
    }

    public function getMedias(): array
    {
        return $this->medias->toArray();
    }

    public function addMedia(Media $media): void
    {
        $media->setProduct($this);
        $this->medias->add($media);
        $this->record(new ProductMediaWasAddedDomainEvent($this->uuid->value, $media->toArray()));
    }

    public function removeMedia(Media $media): void
    {
        $this->medias->removeElement($media);
        $this->record(new ProductMediaWasDeletedDomainEvent($this->uuid->value, $media->getUuid()));
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PrePersist]
    public function prePersist(PrePersistEventArgs $event): void
    {
        $this->createdAt ??= new DateTimeImmutable();
        $this->updatedAt ??= new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->updatedAt ??= new DateTimeImmutable();
    }

    public function toArray(): array
    {
        $medias = array_map(static fn (Arrayable $media): array => $media->toArray(), $this->medias->toArray());
        $cover = array_shift($medias);

        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title->value,
            'category' => $this->category->toArray(),
            'price' => $this->price->toArray(),
            'cover' => $cover,
            'medias' => $medias,
            'viewed_count' => $this->viewedCount,
            'description' => $this->description->value,
            // 'is_active' => $this->isActive,
            'created_at' => $this->createdAt->getTimestamp(),
            'updated_at' => $this->updatedAt->getTimestamp(),
        ];
    }
}
