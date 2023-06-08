<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class S3TestCommand extends Command
{
    protected $signature = 's3:test';

    protected $description = 'S3 Test command';

    public function handle(): int
    {
        for ($i = 0; $i < 1; $i++) { 
            $randomName = md5(microtime(true));
            Storage::put('test-folder/' . $randomName . '-example.txt', 'test');
        }

        return Command::SUCCESS;
    }
}
