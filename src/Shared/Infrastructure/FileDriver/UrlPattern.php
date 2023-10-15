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
        return match ($file->getMimeType()) {
            MimeTypes::JPG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->getFileName()),
            MimeTypes::JPEG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->getFileName()),
            MimeTypes::PNG->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->getFileName()),
            MimeTypes::GIF->value => sprintf('%s/%sx%s/%s', $file->getPath(), '{width}', '{height}', $file->getFileName()),

            default => sprintf('%s/%s', $file->getPath(), $file->getFileName())
        };
    }
}
