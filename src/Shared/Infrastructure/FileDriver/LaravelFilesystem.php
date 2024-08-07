<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Project\Shared\Domain\FilesystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class LaravelFilesystem implements FilesystemInterface
{
    private int $lengthRandomName = 32;

    public function uploadFile(string $fileClassName, UploadedFile $uploadedFile): File
    {
        $path = $fileClassName::PATH;
        try {
            $bucketPath = '/' . env('AWS_BUCKET');
            list($width, $height) = @getimagesize($uploadedFile->getPathname());
            $mimeType = $uploadedFile->getClientMimeType();
            $extension = $uploadedFile->getClientOriginalExtension();
            $size = $uploadedFile->getSize();
            $fileOriginalName = $uploadedFile->getClientOriginalName();
            $fullPath = $uploadedFile->storeAs($path, $fileName = $this->generateFileName($extension));
            $url = Storage::url($fullPath);

            return $fileClassName::make(
                Uuid::uuid4()->toString(),
                $mimeType,
                $width,
                $height,
                $extension,
                $size,
                $bucketPath . $path,
                $fullPath,
                $fileName,
                $fileOriginalName,
                $url,
            );
        } catch (\Throwable $th) {
            // dd($th->getMessage(), $th->getLine(), $th->getFile());
            // info('File upload message exception', [
            //     'message' => $th->getMessage(),
            //     'file' => $th->getFile(),
            //     'line' => $th->getLine(),
            //     'trace' => $th->getTrace(),
            // ]);
            throw new BadRequestException($th->getMessage());
        }
    }

    private function generateFileName(string $extension): string
    {
        return Str::random($this->lengthRandomName) . '.' . $extension;
    }

    public function deleteFile(?File $file): bool
    {
        if ($file === null) {
            return true;
        }

        if (Storage::exists($fileFullPath = $file->getFullPath())) {
            return Storage::delete($fileFullPath);
        }

        return true;
    }

    protected function deleteDir(string $path): bool
    {
        $this->changeDisk($disk);

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->deleteDirectory($path);

            return true;
        }

        return false;
    }

    public function changeDisk(string &$disk): void
    {
        if (config('app.env') == 'local') {
            $disk = 'public';
        }
    }
}
