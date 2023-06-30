<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    private array $countries = [
        [
            'value' => 'united_states',
            'iso' => 'us',
        ],
        [
            'value' => 'turkmenistan',
            'iso' => 'tm',
        ],
        [
            'value' => 'ukraine',
            'iso' => 'ua',
        ],
        [
            'value' => 'russia',
            'iso' => 'ru',
        ],
        [
            'value' => 'poland',
            'iso' => 'pl',
        ],
        [
            'value' => 'turkey',
            'iso' => 'tr',
        ],
    ];

    public function run(): void
    {
        Country::factory()->createMany($this->countries);
    }
}
