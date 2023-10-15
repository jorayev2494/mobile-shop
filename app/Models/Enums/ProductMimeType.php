<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum ProductMimeType: string
{
    case JPG = 'image/jpg';
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
