<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Commands\Update;

use App\Models\Client;
use Project\Domains\Client\Order\Domain\OrderProduct;
use Project\Domains\Client\Order\Domain\Order;
use Project\Domains\Client\Order\Domain\OrderProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderClientUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderCountryUUID;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderDescription;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderEmail;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderPhone;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderStreet;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class UpdateOrderService
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

    public function execute(UpdateOrderCommand $command): array
    {

        $order = Order::create(
            OrderUUID::fromValue($command->uuid),
            OrderClientUUID::fromValue($this->client->uuid),
            OrderEmail::fromValue($command->email ?? $this->client->email),
            OrderPhone::fromValue($command->phone ?? $this->client->phone),
            OrderCountryUUID::fromValue($command->country_uuid ?? $this->client->country_uuid),
            OrderStreet::fromValue($command->street),
            OrderDescription::fromValue($command->description),
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
