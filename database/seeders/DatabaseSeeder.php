<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(CountrySeeder::class);
        // $this->call(CitySeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ClientSeeder::class);
        // $this->call(CardSeeder::class);
        $this->call(CategorySeeder::class);

        $this->call(ProductSeeder::class);
        // $this->call(AddressSeeder::class);
        // $this->call(OrderSeeder::class);
    }
}
