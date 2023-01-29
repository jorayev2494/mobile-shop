<?php

declare(strict_types=1);

namespace App\Data\Models;

use App\Data\Models\Contracts\ProfileData;

class AdminData extends ProfileData
{
    public function __construct(
        public readonly ?string $first_name,
        public readonly ?string $last_name,
        public readonly string $email,
    ) {
    }
}
