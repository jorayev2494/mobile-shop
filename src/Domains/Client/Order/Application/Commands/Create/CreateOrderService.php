<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Create;

use App\Models\Client;
use Project\Domains\Client\Order\Domain\OrderProduct;
use Project\Domains\Client\Order\Domain\Order;
use Project\Domains\Client\Order\Domain\OrderProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderAddressUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderCardUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderDescription;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderEmail;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderPhone;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Domain\ValueObject\UuidValueObject;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CreateOrderService
{
    private readonly Client $client;

    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly OrderRepositoryInterface $repository,
        private readonly OrderProductRepositoryInterface $orderProductRepository,
    )
    {
        $this->client = $this->authManager->client();        
    }

    public function execute(CreateOrderCommand $command): array
    {
        $orderUUID = OrderUUID::generate();
        $clientUUID = OrderClientUUID::fromValue($this->client->uuid);
        $email = OrderEmail::fromValue($command->email ?? $this->client->email);
        $phone = OrderPhone::fromValue($command->phone ?? $this->client->phone ?? '55');
        $description = OrderDescription::fromValue($command->description);
        $cardUUID = OrderCardUUID::fromValue($command->card_uuid);
        $addressUUID = OrderAddressUUID::fromValue($command->address_uuid);

        $orderProducts = array_map(static fn (array $product): OrderProduct => OrderProduct::createFromArray($product + ['uuid' => UuidValueObject::generate()->value, 'order_uuid' => $orderUUID->value]), (array) $command->products);

        $order = Order::create(
            $orderUUID,
            $clientUUID,
            $email,
            $phone,
            $description,
            $cardUUID,
            $addressUUID,
            'created',
            $command->quality,
            $command->sum,
            $command->discard_sum,
        );

        $this->repository->save($order);
        $this->orderProductRepository->save($orderProducts);

        return ['uuid' => $orderUUID->value];
    }
}
