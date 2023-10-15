<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

class UrlPattern
{
    public readonly MimeTypes $mimeType;

    public static function make(File $file): string
    {
        return '{endpoint}' . self::makePattern($file);
    }

    private static function makePattern(File $file): string
    {
        return match ($file->mime_type) {
            MimeTypes::JPG->value => sprintf('%s/%sx%s/%s', $file->path, '{width}', '{height}', $file->name),
            MimeTypes::JPEG->value => sprintf('%s/%sx%s/%s', $file->path, '{width}', '{height}', $file->name),
            MimeTypes::PNG->value => sprintf('%s/%sx%s/%s', $file->path, '{width}', '{height}', $file->name),
            MimeTypes::GIF->value => sprintf('%s/%sx%s/%s', $file->path, '{width}', '{height}', $file->name),

            default => sprintf('%s/%s', $file->path, $file->name)
        };
    }
}
