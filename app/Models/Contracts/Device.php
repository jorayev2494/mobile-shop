<?php

declare(strict_types=1);

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Device
{
    public function devices(): MorphMany;

    public function addDevice(string $deviceId): \App\Models\Device;

    public function removeDevice(string $deviceId): bool;
}
