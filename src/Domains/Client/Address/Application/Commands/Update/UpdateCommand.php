<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Commands\Update;
use Project\Shared\Application\Command\Command;

final class UpdateCommand extends Command
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $full_name,
        public readonly string $first_address,
        public readonly string $second_address,
        public readonly string $zip_code,
        public readonly string $country_uuid,
        public readonly string $city_uuid,
        public readonly string $district,
        public readonly bool $is_active,
    )
    {
        
    }
}
