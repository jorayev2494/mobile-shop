<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Client;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class AddressSeeder extends Seeder
{

    /**
     * @var Collection<TKey, Client> $clients
     */
    private readonly Collection $clients;

    /**
     * @var Collection<TKey, Country> $clients
     */
    private readonly Collection $countries;

    public function __construct()
    {
        $this->clients = Client::query()->get('uuid');
        $this->countries = Country::query()->get('uuid');
    }

    public function run(): void
    {
        foreach ($this->clients as $key => $client) {
            $client->addresses()->saveMany(
                Address::factory()->count(random_int(5, 15))->make([
                    'country_uuid' => ($county = $this->countries->random()->first())->uuid,
                    'city_uuid' => $county->cities->random()->first()->uuid // $this->cities->random(),
                ])
            );
        }
    }
}
