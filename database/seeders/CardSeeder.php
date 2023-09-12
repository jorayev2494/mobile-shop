<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CardSeeder extends Seeder
{
    /**
     * @var Collection<TKey, Client> $clients
     */
    private Collection $clients;

    public function __construct()
    {
        $this->clients = Client::all();
    }

    public function run(): void
    {
        $this->clients->each(
            static fn (Client $client): iterable => $client->cards()->saveMany(Card::factory()->count(5)->make())
        );
    }
}
