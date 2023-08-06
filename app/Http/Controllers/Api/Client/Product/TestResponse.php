<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Product;

use Illuminate\Contracts\Support\Arrayable;

class TestResponse implements Arrayable
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
    )
    {

    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
