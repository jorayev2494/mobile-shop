<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Order\Create;

use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid as AddressUuid;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid as CardUuid;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid as ClientUuid;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProduct\ValueObjects\Quantity;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid as ProductUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly CardRepositoryInterface $cardRepository,
        private readonly AddressRepositoryInterface $addressRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $client = $this->clientRepository->findByUuid(ClientUuid::fromValue($command->clientUuid));
        $card = $this->cardRepository->findByUuid(CardUuid::fromValue($command->cardUuid));
        $address = $this->addressRepository->findByUuid(AddressUuid::fromValue($command->addressUuid));
        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($command->currencyUuid));

        $order = Order::create(
            Uuid::fromValue($command->uuid),
            $client,
            $card,
            $address,
            $currency,
            Email::fromValue($command->email ?? $client->getEmail()->value),
            Phone::fromValue($command->phone ?? $client->getPhone()->value),
            Note::fromValue($command->note),
        );

        $quantity = $sum = 0;
        $orderProducts = [];
        foreach ($command->cartProducts as $cartProduct) {
            $product = $this->productRepository->findByUuid(ProductUuid::fromValue($cartProduct['uuid']));

            if ($product === null) {
                continue;
            }

            $quantity += $cartProduct['quantity'];
            $sum += $product->getPrice()->getValue() * $cartProduct['quantity'];
            $orderProducts[] = OrderProduct::make($product, Quantity::fromValue($cartProduct['quantity']));
            // $order->addOrderProduct($orderProduct);
        }

        $order->addOrderProducts($orderProducts);
        $order->setMeta(new Meta($quantity, $sum));

        $this->repository->save($order);
        $this->eventBus->publish(...$order->pullDomainEvents());
    }
}
