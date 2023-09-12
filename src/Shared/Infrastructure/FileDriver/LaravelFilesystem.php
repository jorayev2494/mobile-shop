<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Project\Shared\Domain\FilesystemInterface;
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
            $path = $bucketPath . $path;
            $mimeType = $uploadedFile->getClientMimeType();
            $extension = $uploadedFile->getClientOriginalExtension();
            $size = $uploadedFile->getSize();
            $fileOriginalName = $uploadedFile->getClientOriginalName();
            $fileName = Str::random($this->lengthRandomName) . '.' . $extension;
            $fullPath = $uploadedFile->storeAs($path, $fileName);
            $url = Storage::url($fullPath);

            return $fileClassName::make(
                $mimeType,
                $width,
                $height,
                $extension,
                $size,
                $path,
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

    public function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile): ?File
    {
        $this->deleteFile($path, $deleteFileName);

        return $this->uploadFile($path, $uploadedFile);
    }

    public function deleteFile(File $file): bool
    {
        if (Storage::exists($file->getFullPath())) {
            return Storage::delete($file->getFullPath());
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
