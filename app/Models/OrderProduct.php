<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property string $order_uuid
 * @property string $product_uuid
 * @property int $quality
 * @property int $sum
 * @property int $discard_sum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereDiscardSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereOrderUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereProductUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|OrderProduct whereUuid($value)
 */
class OrderProduct extends Pivot
{
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'order_uuid',
        'product_uuid',
        'quality',
        'sum',
        'discard_sum',
    ];
}
