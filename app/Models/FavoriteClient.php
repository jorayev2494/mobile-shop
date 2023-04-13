<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavoriteClient extends Pivot
{
    protected $fillable = [
        'client_uuid',
        'product_uuid',
    ];
}
