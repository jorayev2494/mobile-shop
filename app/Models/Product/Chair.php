<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product\Chair
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Product\ChairFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Chair newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chair newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chair query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chair whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chair whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Chair whereUuid($value)
 */
class Chair extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';
}
