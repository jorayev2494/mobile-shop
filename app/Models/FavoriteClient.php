<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\FavoriteClient
 *
 * @property int $id
 * @property string $client_uuid
 * @property string $product_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient whereClientUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient whereProductUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FavoriteClient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FavoriteClient extends Pivot
{
    protected $fillable = [
        'client_uuid',
        'product_uuid',
    ];
}
