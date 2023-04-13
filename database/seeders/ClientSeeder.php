<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ClientSeeder extends Seeder
{

    private readonly Collection $countries;

    private array $clientEmails = [
        'client@gmail.com',
        'client2@gmail.com',
    ];

    public function __construct()
    {
        $this->countries = Country::all();
    }

    public function run(): void
    {
        Client::factory()->createMany(
            array_map(
                fn (string $email): array => compact('email') + ['country_uuid' => $this->countries->random(1)->first()->uuid],
                $this->clientEmails,
            )
        );

        for ($i = 1; $i < 48; $i++) { 
            Client::factory()->create(['country_uuid' => $this->countries->random(1)->first()->uuid]);
        };
    }
}
