<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Product;
use Project\Shared\Domain\Aggregate\AggregateRoot;

class Cover extends AggregateRoot
{
    public function __construct(
        public readonly string $uuid,
        public readonly int $width,
        public readonly int $height,
        public readonly string $extension,
        public readonly int $size,
        public readonly string $fileOriginalName,
        public readonly string $urlPattern,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'width' => $this->width,
            'height' => $this->height,
            'extension' => $this->extension,
            'size' => $this->size,
            'file_original_name' => $this->fileOriginalName,
            'url_pattern' => $this->urlPattern,
        ];
    }

}
