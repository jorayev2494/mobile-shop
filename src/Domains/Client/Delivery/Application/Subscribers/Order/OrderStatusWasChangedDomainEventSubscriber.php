<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Order;

use Project\Domains\Client\Delivery\Domain\Order\Events\OrderStatusWasChangedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class OrderStatusWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly MailerInterface $mailer,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            OrderStatusWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(OrderStatusWasChangedDomainEvent $event): void
    {
        if ($event->status !== 'delivery') {
            return;
        }

        $order = $this->repository->findByUuid(Uuid::fromValue($event->uuid));

        $orderEmail = $order->getEmail()->value ?? $order->getCustomer()->getEmail()->value;

        $view = view('mail.client.order.order_status_was_changed', [
            'status' => $event->status,
        ])->render();

        $mailMessage = (new Email())
                ->from(getenv('MAIL_FROM_ADDRESS'))
                ->to($orderEmail)
                ->subject('Your order status was changed!')
                ->html($view);

        $this->mailer->send($mailMessage);
    }

}
