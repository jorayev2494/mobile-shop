<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Country;
use App\Models\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class OrderSeeder extends Seeder
{
    private readonly Collection $clients;
    private readonly Collection $countries;
    private readonly Collection $products;

    public function __construct()
    {
        $this->clients = Client::query()->get();
        $this->countries = Country::query()->get();
        $this->products = Product::query()->get();
    }

    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            /** @var Order $order */
            $order = Order::factory()->create([
                'client_uuid' => $this->clients->random(1)->first()->uuid,
                'country_uuid' => $this->countries->random(1)->first()->uuid,
                'status' => OrderStatus::PAID,
                'quality' => 0,
                'sum' => 0,
                'discard_sum' => 0,
            ]);

            $order->update($this->itemsGenerate($order));
        }
    }

    private function itemsGenerate(Order $order, int $min = 2, int $max = 2): array
    {
        $quality = $sum = $discard_sum = 0;

        for ($j = 0; $j < random_int($min, $max); $j++) {
            $q = 0;

            $order->items()->syncWithPivotValues(
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
