<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @template-implements Arrayable
 */
abstract class File implements Arrayable
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    protected string $uuid;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $width;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $height;

    #[ORM\Column(name: 'mime_type', type: Types::STRING)]
    protected string $mimeType;

    #[ORM\Column(type: Types::STRING)]
    protected string $extension;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $size;

    #[ORM\Column(type: Types::STRING)]
    protected string $path;

    #[ORM\Column(name: 'full_path', type: Types::STRING)]
    protected string $fullPath;

    #[ORM\Column(name: 'file_name', type: Types::STRING)]
    protected string $fileName;

    #[ORM\Column(name: 'file_original_name', type: Types::STRING)]
    protected string $fileOriginalName;

    #[ORM\Column(type: Types::STRING)]
    protected string $url;

    #[ORM\Column(name: 'url_pattern', type: Types::STRING)]
    protected string $urlPattern;

    #[ORM\Column(name: 'downloaded_count', type: Types::INTEGER)]
    protected int $downloadedCount;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
    protected DateTimeImmutable $updatedAt;

    protected function __construct(
        string $uuid,
        string $mimeType,
        ?int $width,
        ?int $height,
        string $extension,
        int $size,
        string $path,
        string $fullPath,
        string $fileName,
        string $fileOriginalName,
        string $url,
        int $downloadedCount,
        string $urlPattern = null,
    ) {
        $this->uuid = $uuid;
        $this->mimeType = $mimeType;
        $this->width = $width;
        $this->height = $height;
        $this->extension = $extension;
        $this->size = $size;
        $this->path = $path;
        $this->fullPath = $fullPath;
        $this->fileName = $fileName;
        $this->fileOriginalName = $fileOriginalName;
        $this->url = $url;
        $this->downloadedCount = $downloadedCount;
        $this->urlPattern = is_null($urlPattern) ? $this->makeUrlPattern($this) : $urlPattern;
    }

    public static function make(
        string $uuid,
        string $mimeType,
        ?int $width,
        ?int $height,
        string $extension,
        int $size,
        string $path,
        string $fullPath,
        string $fileName,
        string $fileOriginalName,
        string $url,
        int $downloadedCount = 0,
        string $urlPattern = null,
    ): static {
        return new static(
            $uuid,
            $mimeType,
            $width,
            $height,
            $extension,
            $size,
            $path,
            $fullPath,
            $fileName,
            $fileOriginalName,
            $url,
            $downloadedCount,
            $urlPattern,
        );
    }

    protected function makeUrlPattern(File $file): string
    {
        $res = match ($file->mimeType) {
            MimeTypes::JPG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->fileName),
            MimeTypes::JPEG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->fileName),
            MimeTypes::PNG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->fileName),
            MimeTypes::GIF->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->fileName),

            default => sprintf('%s/%s', $file->getPath(), $file->fileName)
        };

        return "{endpoint}{$res}";
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFullPath(): string
    {
        return $this->fullPath;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFileOriginalName(): string
    {
        return $this->fileOriginalName;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDownloadedCount(): int
    {
        return $this->downloadedCount;
    }

    public function getUrlPattern(): string
    {
        return $this->urlPattern;
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

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function isEquals(self $other): bool
    {
        return $this->uuid === $other->uuid;
    }

    public function isNotEquals(self $other): bool
    {
        return $this->uuid !== $other->uuid;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'mime_type' => $this->mimeType,
            'width' => $this->width,
            'height' => $this->height,
            'extension' => $this->extension,
            'size' => $this->size,
            'path' => $this->path,
            'full_path' => $this->fullPath,
            'file_name' => $this->fileName,
            'file_original_name' => $this->fileOriginalName,
            'url' => $this->url,
            'downloaded_count' => $this->downloadedCount,
            'url_pattern' => $this->urlPattern,
        ];
    }
}
