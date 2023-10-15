<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

class Avatar
{
    public function __construct(
        public readonly string $uuid,
        public readonly int $width,
        public readonly int $height,
        public readonly string $mimeType,
        public readonly int $size,
        public readonly string $fileOriginalName,
        public readonly string $urlPattern,
    ) {

    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'width' => $this->width,
            'height' => $this->height,
            'mime_type' => $this->mimeType,
            'size' => $this->size,
            'file_original_name' => $this->fileOriginalName,
            'url_pattern' => $this->urlPattern,
        ];
    }
}
