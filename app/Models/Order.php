<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Order
 *
 * @property string $uuid
 * @property string|null $email
 * @property string|null $phone
 * @property string $country_uuid
 * @property string $street
 * @property string|null $description
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCountryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUuid($value)
 * @mixin \Eloquent
 * @property string $client_uuid
 * @property string $status
 * @property int $quality
 * @property int $sum
 * @property int $discard_sum
 * @property-read \App\Models\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClientUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscardSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSum($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property string $address_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressUuid($value)
 * @property string $card_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCardUuid($value)
 * @property int $number
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNumber($value)
 */
class Order extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        // 'number',
        'client_uuid',
        'email',
        'phone',
        'card_uuid',
        'client_uuid',
        'description',
        'status',
        'quality',
        'sum',
        'discard_sum',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, OrderProduct::class, 'order_uuid', 'product_uuid', 'uuid', 'uuid')->using(OrderProduct::class)->withPivot('*');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_uuid', 'uuid');
    }
}
