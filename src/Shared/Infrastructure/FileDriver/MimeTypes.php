<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

enum MimeTypes: string
{
    // Images
    case JPG = 'image/jpg';
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';

    // Videos
    case MP4 = 'video/mp4';

    // Documents
    case PDF = 'application/pdf';
}
