<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CitySeeder extends Seeder
{
    /**
     * @var Collection<int, Country>
     */
    private readonly Collection $countries;

    public function __construct()
    {
        $this->countries = Country::query()->get(['uuid']);
    }

    public function run(): void
    {
        foreach ($this->countries as $key => $country) {
            $country->cities()->saveMany(
                City::factory()->count(random_int(5, 15))->make()
            );
        }
    }
}
