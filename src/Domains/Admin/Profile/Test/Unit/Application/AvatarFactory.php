<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Test\Unit\Application;

use Project\Domains\Admin\Profile\Domain\Avatar\Avatar;

class AvatarFactory
{
    public const UUID = '9320c10d-f21f-4dd5-997e-ad0140249c9c';

    public const MINE_TYPE = 'images/jpeg';

    public const WIDTH = 400;

    public const HEIGHT = 600;

    public const EXTENSION = 'jpg';

    public const SIZE = 12345;

    public const PATH = '/local/products/medias';

    public const FULL_PATH = 'products/medias/YzOc8aHSxfKYYdiEWpvtiwqbE01JylES.png';

    public const FILE_NAME = 'YzOc8aHSxfKYYdiEWpvtiwqbE01JylES.png';

    public const FILE_ORIGINAL_NAME = '93c272ff-a71e-46d6-96c2-867d6b7e7b49-fake.png';

    public const URL = 'http://minio:9000/local/products/medias/YzOc8aHSxfKYYdiEWpvtiwqbE01JylES.png';

    public const DOWNLOADED_COUNT = 0;

    public const URL_PATTERN = '{endpoint}/local/products/medias/{width}x{height}/YzOc8aHSxfKYYdiEWpvtiwqbE01JylES.png';

    public static function make(
        string $uuid = null,
        string $mineType = null,
        int $width = null,
        int $height = null,
        string $extension = null,
        int $size = null,
        string $path = null,
        string $fullPath = null,
        string $fileOriginalName = null,
        string $url = null,
        string $urlPattern = null,
        int $downloadedCount = null,
    ): Avatar
    {
        return Avatar::make(
            $uuid ?? self::UUID,
            $mineType ?? self::MINE_TYPE,
            $width ?? self::WIDTH,
            $height ?? self::HEIGHT,
            $extension ?? self::EXTENSION,
            $size ?? self::SIZE,
            $path ?? self::PATH,
            $fullPath ?? self::FULL_PATH,
            $fileOriginalName ?? self::FILE_NAME,
            $url ?? self::FILE_ORIGINAL_NAME,
            $urlPattern ?? self::URL,
            $downloadedCount ?? self::DOWNLOADED_COUNT,
        );
    }
}
