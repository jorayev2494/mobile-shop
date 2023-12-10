<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Media;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Media\Media;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\MediaFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Shared\Infrastructure\FileDriver\File;

/**
 * @group order-domain
 * @group order-media-domain
 */
class MediaTest extends TestCase
{
    public function testMake(): void
    {
        $media = Media::make(
            MediaFactory::UUID,
            MediaFactory::MINE_TYPE,
            MediaFactory::WIDTH,
            MediaFactory::HEIGHT,
            MediaFactory::EXTENSION,
            MediaFactory::SIZE,
            MediaFactory::PATH,
            MediaFactory::FULL_PATH,
            MediaFactory::FILE_NAME,
            MediaFactory::FILE_ORIGINAL_NAME,
            MediaFactory::URL,
            MediaFactory::DOWNLOADED_COUNT,
            MediaFactory::URL_PATTERN,
        );

        $this->assertInstanceOf(File::class, $media);
        $this->assertInstanceOf(Media::class, $media);
        $this->assertNotInstanceOf(AggregateRoot::class, $media);

        $this->assertIsString($media->getUuid());
        $this->assertSame(MediaFactory::UUID, $media->getUuid());

        $this->assertIsString($media->getMimeType());
        $this->assertSame(MediaFactory::MINE_TYPE, $media->getMimeType());

        $this->assertIsInt($media->getWidth());
        $this->assertSame(MediaFactory::WIDTH, $media->getWidth());

        $this->assertIsInt($media->getHeight());
        $this->assertSame(MediaFactory::HEIGHT, $media->getHeight());

        $this->assertIsString($media->getExtension());
        $this->assertSame(MediaFactory::EXTENSION, $media->getExtension());

        $this->assertIsInt($media->getSize());
        $this->assertSame(MediaFactory::SIZE, $media->getSize());

        $this->assertIsString($media->getPath());
        $this->assertSame(MediaFactory::PATH , $media->getPath());

        $this->assertIsString($media->getFullPath());
        $this->assertSame(MediaFactory::FULL_PATH , $media->getFullPath());

        $this->assertIsString($media->getFileName());
        $this->assertSame(MediaFactory::FILE_NAME , $media->getFileName());

        $this->assertIsString($media->getFileOriginalName());
        $this->assertSame(MediaFactory::FILE_ORIGINAL_NAME , $media->getFileOriginalName());

        $this->assertIsString($media->getUrl());
        $this->assertSame(MediaFactory::URL , $media->getUrl());

        $this->assertIsInt($media->getDownloadedCount());
        $this->assertSame(MediaFactory::DOWNLOADED_COUNT , $media->getDownloadedCount());

        $this->assertIsString($media->getUrlPattern());
        $this->assertSame(MediaFactory::URL_PATTERN , $media->getUrlPattern());
    }

    public function testMediaSetProduct(): void
    {
        $media = MediaFactory::make();

        $this->assertNull($media->getProduct());

        $media->setProduct($product = ProductFactory::make('580c5eca-a088-4756-894c-c78376f9efbc'));

        $this->assertNotNull($media->getProduct());
        $this->assertInstanceOf(Uuid::class, $product->getUuid());
        $this->assertSame('580c5eca-a088-4756-894c-c78376f9efbc', $product->getUuid()->value);
    }
}
