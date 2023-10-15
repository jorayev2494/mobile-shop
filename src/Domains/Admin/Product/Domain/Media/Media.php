<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Media;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Shared\Infrastructure\FileDriver\File;
use Project\Shared\Infrastructure\FileDriver\MimeTypes;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table('product_medias')]
class Media extends File
{
    public const PATH = '/products/medias';

    #[ORM\Column(name: 'product_uuid', type: Types::STRING, nullable: false)]
    private string $productUuid;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'medias', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'product_uuid', referencedColumnName: 'uuid', nullable: false)]
    private Product $product;

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}
