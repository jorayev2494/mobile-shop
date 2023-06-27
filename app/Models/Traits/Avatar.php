<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Avatar
{
    public function avatar(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable', 'fileable_type', 'fileable_uuid', 'uuid');
    }
}
