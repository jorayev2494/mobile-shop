<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\RabbitMQ\Command\CommandHandlerLocator;

class CommandBusList extends Command
{
    protected $signature = 'command-bus:list';

    protected $description = 'Command description';

    public function handle(CommandHandlerLocator $commandHandlerLocator): int
    {
        // $res = $commandHandlerLocator->getRegisteredCommands();

        return Command::SUCCESS;
    }
}
