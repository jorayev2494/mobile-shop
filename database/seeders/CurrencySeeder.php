<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    private array $currencyCodes = [
        'USD',
        'TMT',
        'UAH',
        'RUB',
        'PLN',
        'TRY',
    ];

    public function run(): void
    {
        Currency::factory()->createMany(
            array_map(
                static fn (string $value): array => compact('value'),
                $this->currencyCodes
            )
        );
    }
}
