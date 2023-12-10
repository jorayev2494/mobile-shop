<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Cart;

use Project\Domains\Client\Cart\Domain\Cart\Events\CartWasConfirmedDomainEvent;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid as AddressUuid;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid as CardUuid;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid as ClientUuid;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid as ProductUuid;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProduct\ValueObjects\Quantity;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CartWasConfirmedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly CardRepositoryInterface $cardRepository,
        private readonly AddressRepositoryInterface $addressRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CartWasConfirmedDomainEvent::class,
        ];
    }

    public function __invoke(CartWasConfirmedDomainEvent $event): void
    {
        $cartProducts = $event->cartProducts;
        $client = $this->clientRepository->findByUuid(ClientUuid::fromValue($event->authorUuid));
        $card = $this->cardRepository->findByUuid(CardUuid::fromValue($event->cardUuid));
        $address = $this->addressRepository->findByUuid(AddressUuid::fromValue($event->addressUuid));
        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($event->currencyUuid));

        $order = Order::create(
            Uuid::fromValue($event->uuid),
            Email::fromValue($event->email ?? $client->getEmail()->value),
            Phone::fromValue($event->phone ?? $client->getPhone()->value),
            Note::fromValue($event->note),
        );

        $quantity = $sum = 0;
        foreach ($cartProducts as $key => $cartProduct) {
            $product = $this->productRepository->findByUuid(ProductUuid::fromValue($cartProduct['product']['uuid']));

            if ($product === null) {
                return;
            }

            $quantity += $cartProduct['quantity'];
            $sum += $product->getPrice()->getValue() * $cartProduct['quantity'];
            $orderProduct = OrderProduct::create($product, Quantity::fromValue($cartProduct['quantity']));
            $order->addOrderProduct($orderProduct);
        }

        $order->setMeta(new Meta($quantity, $sum));
        $order->setCard($card);
        $order->setAddress($address);
        $order->setCurrency($currency);
        $client->addOrder($order);

        $this->repository->save($order);
        $this->eventBus->publish(...$order->pullDomainEvents());
    }
}
