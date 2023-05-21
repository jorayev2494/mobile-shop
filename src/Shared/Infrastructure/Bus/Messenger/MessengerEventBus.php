<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Bus\Messenger;

use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\Bus\Event\DomainEvent;
use Project\Shared\Infrastructure\Bus\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class MessengerEventBus implements EventBusInterface
{

    private readonly MessageBus $bus;

    public function __construct(iterable $subscribers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    CallableFirstParameterExtractor::forPipedCallables($subscribers)
                )
            ),
        ]);
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch($event);
            } catch (NoHandlerForMessageException) {
                // TODO optionally throw exception or not
            }
        }
    }
}