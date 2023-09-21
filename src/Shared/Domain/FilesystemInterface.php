<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

use Illuminate\Http\UploadedFile;
use Project\Shared\Infrastructure\FileDriver\File;

interface FilesystemInterface {
    public function uploadFile(string $fileClassName, UploadedFile $uploadedFile): File;
    // public function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile): ?File;
    public function deleteFile(?File $file): bool;
    public function changeDisk(string &$disk): void;
}
