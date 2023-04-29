<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Client;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

/**
 * @template TKey of array-key
 */
class OrderSeeder extends Seeder
{
    /**
     * @var Collection<TKey, Client> $clients
     */
    private readonly Collection $clients;

    /**
     * @var Collection<TKey, Product> $products
     */
    private readonly Collection $products;

    /**
     * @var Collection<TKey, Card> $cards;
     */
    private readonly Collection $cards;

    public function __construct()
    {
        $this->clients = Client::query()->get();
        $this->products = Product::query()->get();
        $this->cards = Card::query()->get();
    }

    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {

            $client = $this->clients->random(1)->first();

            /** @var Order $order */
            $order = Order::factory()->create([
                'client_uuid' => $client->uuid,
                'card_uuid' => $client->cards->random(1)->first()->uuid,
                'address_uuid' => $client->addresses->random(1)->first()->uuid,
                'status' => OrderStatus::PAID,
                'quality' => 0,
                'sum' => 0,
                'discard_sum' => 0,
            ]);

            $order->update($this->productsGenerate($order));
        }
    }

    private function productsGenerate(Order $order, int $min = 2, int $max = 2): array
    {
        $quality = $sum = $discard_sum = 0;

        for ($j = 0; $j < random_int($min, $max); $j++) {
            $q = 0;

            $order->products()->syncWithPivotValues(
                /** @var Collection<int, Product> $randomProducts */
                $randomProducts = $this->products->random(1),
                [
                    'quality' => $q = random_int(2, 5),
                    'sum' => $s = $randomProducts->sum(static fn (Product $product): int => $product->price) * $q,
                    'discard_sum' => $ds = $randomProducts->sum(static fn (Product $product): ?int => $product->discard_changes) * $q,
                ],
                false
            );
        
            $quality += $q;
            $sum += $s;
            $discard_sum += $ds;
        }

        return compact('quality', 'sum', 'discard_sum');
    }
}
