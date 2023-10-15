<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class S3TestFilesCommand extends Command
{
    protected $signature = 's3:test-files';

    protected $description = 'S3 test files command';

    public function handle(): int
    {
        $files = Storage::allFiles();

        foreach ($files as $key => $file) {
            $fileUrl = Storage::url($file);
            $this->info($fileUrl);
        }

        return Command::SUCCESS;
    }
}
