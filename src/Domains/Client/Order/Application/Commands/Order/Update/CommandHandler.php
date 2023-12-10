<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Order\Update;

use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid as AddressUuid;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
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
        $order = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

//        $client = $this->clientRepository->findByUuid(ClientUuid::fromValue($command->clientUuid));
        // $card = $this->cardRepository->findByUuid(CardUuid::fromValue($command->cardUuid));
        $address = $this->addressRepository->findByUuid(AddressUuid::fromValue($command->addressUuid));
        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($command->currencyUuid));

        $order->changeAddress($address);
        $order->changeCurrency($currency);
        $order->changeNote(Note::fromValue($command->note));

//        $quantity = $sum = 0;
//        $orderProducts = [];
//        foreach ($command->cartProducts as $cartProduct) {
//            $product = $this->productRepository->findByUuid(ProductUuid::fromValue($cartProduct['uuid']));
//
//            if ($product === null) {
//                continue;
//            }
//
//            $quantity += $cartProduct['quantity'];
//            $sum += $product->getPrice()->getValue() * $cartProduct['quantity'];
//            $orderProducts[] = OrderProduct::make($product, Quantity::fromValue($cartProduct['quantity']));
//            // $order->addOrderProduct($orderProduct);
//        }

//        $order->addOrderProducts($orderProducts);
//        $order->setMeta(new Meta($quantity, $sum));

        $this->repository->save($order);
        $this->eventBus->publish(...$order->pullDomainEvents());
    }
}
