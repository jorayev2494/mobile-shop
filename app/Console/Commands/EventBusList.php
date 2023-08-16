<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Project\Shared\Infrastructure\Bus\DomainEventSubscriberLocator;

class EventBusList extends Command
{
    protected $signature = 'event-bus:list';

    protected $description = 'Command description';

    public function handle(DomainEventSubscriberLocator $domainEventSubscriberLocator): int
    {
        $res = $domainEventSubscriberLocator->getRegisteredSubscribers();
        dd($res);

        return Command::SUCCESS;
    }
}
