<?php

declare(strict_types=1);

namespace Project\Infrastructure\Bus\Event\Log;

use Illuminate\Support\Facades\Log;
use Project\Shared\Domain\Bus\Event\EventBus;
use Project\Shared\Domain\Bus\Event\Event;

final class LogEventBus implements EventBus
{
    public function dispatch(Event ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->publishEvent($event);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    private function publishEvent(Event $event): void
    {
        Log::info($event->getType(), $event->toArray());
    }
}
