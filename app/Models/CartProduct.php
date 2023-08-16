<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CartProduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $cart_uuid
 * @property string $product_uuid
 * @property string $currency_uuid
 * @property int $quality
 * @property int $price
 * @property int|null $discount_percentage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCartUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereCurrencyUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereProductUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartProduct whereUpdatedAt($value)
 */
class CartProduct extends Pivot
{
    protected $fillable = [
        'cart_uuid',
        'product_uuid',
        'cart_currency_uuid',
        'cart_quality',
        'cart_price',
        'cart_discount_percentage',
    ];
}
