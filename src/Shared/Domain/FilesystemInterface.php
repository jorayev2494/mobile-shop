<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

use App\Models\File;
use Illuminate\Http\UploadedFile;

interface FilesystemInterface {
    public function uploadFile(string $path, UploadedFile $uploadedFile): File;
    public function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile): ?File;
    public function deleteFile(string $path, ?string $deleteFileName): bool;
    public function changeDisk(string &$disk): void;
}
