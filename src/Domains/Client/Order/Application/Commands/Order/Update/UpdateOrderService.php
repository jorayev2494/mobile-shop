<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Order\Update;

use App\Models\Client;
use Project\Domains\Client\Order\Application\Commands\Update\UpdateOrderCommand;
use Project\Domains\Client\Order\Domain\Order;
use Project\Domains\Client\Order\Domain\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderAddressUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderCardUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderDescription;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderEmail;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderPhone;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UpdateOrderService
{
    private readonly Client $client;

    public function __construct(
        private readonly AuthManagerInterface $authManager,
        private readonly OrderRepositoryInterface $repository,
        private readonly OrderProductRepositoryInterface $orderProductRepository,
    ) {
        $this->client = $this->authManager->client();
    }

    public function execute(UpdateOrderCommand $command): array
    {

        $orderUUID = OrderUUID::fromValue($command->uuid);
        $clientUUID = OrderClientUUID::fromValue($this->client->uuid);
        $email = OrderEmail::fromValue($command->email ?? $this->client->email);
        $phone = OrderPhone::fromValue($command->phone ?? $this->client->phone);
        $description = OrderDescription::fromValue($command->description);
        $cardUUID = OrderCardUUID::fromValue($command->card_uuid);
        $addressUUID = OrderAddressUUID::fromValue($command->address_uuid);

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

        $orderProducts = array_map(static fn (array $product): OrderProduct => OrderProduct::createFromArray($product + ['order_uuid' => $command->uuid]), (array) $command->products);
        $this->orderProductRepository->save($orderProducts);

        return ['uuid' => $command->uuid];
    }
}
