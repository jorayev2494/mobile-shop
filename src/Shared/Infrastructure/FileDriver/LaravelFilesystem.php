<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\FileDriver;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Project\Shared\Domain\FilesystemInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

use function Lambdish\Phunctional\get;

final class LaravelFilesystem implements FilesystemInterface
{
    private int $lengthRandomName = 32;

    public function uploadFile(string $path, UploadedFile $uploadedFile): array
    {
        try {
            list($fileData['width'], $fileData['height']) = @getimagesize($uploadedFile->getPathname());
            $fileData['path'] = $path;
            $fileData['mime_type'] = $uploadedFile->getClientMimeType();
            $fileData['type'] = $uploadedFile->getClientOriginalExtension();
            $fileData['extension'] = $uploadedFile->getClientOriginalExtension();
            $fileData['size'] = $uploadedFile->getSize();
            $fileData['file_original_name'] = $uploadedFile->getClientOriginalName();
            $fileData['name'] = Str::random($this->lengthRandomName) . '.' . $fileData['type'];
            $fileData['full_path'] = '/' . $uploadedFile->storeAs($path, $fileData['name']);
            $fileData['disk'] = env('FILESYSTEM_DISK');
            $fileData['url'] = Storage::url($fileData['full_path']);
        } catch (\Throwable $th) {
            info('File upload message exception', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTrace(),
            ]);
            throw new BadRequestException('File load exception!');
        }

        return $fileData;
    }

    public function updateFile(string $path, ?string $deleteFileName, UploadedFile $uploadedFile): array
    {
        $this->deleteFile($path, $deleteFileName);

        return $this->uploadFile($path, $uploadedFile);
    }

    public function deleteFile(string $path, ?string $deleteFileName): bool
    {
        if (!empty($deleteFileName) && Storage::exists($path)) {
            $deleteFileName = str_replace($path . '/', '', $deleteFileName);

            return Storage::delete($path . '/' . $deleteFileName);
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
