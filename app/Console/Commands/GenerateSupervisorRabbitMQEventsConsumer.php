<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSupervisorRabbitMQEventsConsumer extends Command
{
    protected $signature = 'command:name';

    protected $description = 'Command description';

    public function handle(): int
    {
        return Command::SUCCESS;
    }
}
