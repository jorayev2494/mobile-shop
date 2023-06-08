<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

use Illuminate\Http\UploadedFile;

interface FilesystemInterface {
    public function uploadFile(string $path, UploadedFile $uploadedFile): array;
    public function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile): array;
    public function deleteFile(string $path, ?string $deleteFileName): bool;
    public function changeDisk(string &$disk): void;
}
