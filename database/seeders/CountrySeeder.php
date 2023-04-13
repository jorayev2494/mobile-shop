<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    private array $countries = [
        'united_states',
        'turkmenistan',
        'ukraine',
        'russia',
        'poland',
        'turkey',
    ];

    public function run(): void
    {
        Country::factory()->createMany(
            array_map(
                static fn (string $value): array => compact('value'),
                $this->countries
            )
        );
    }
}
