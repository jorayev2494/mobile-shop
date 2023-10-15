<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * App\Models\Product
 *
 * @property string $uuid
 * @property string $title
 * @property string $category_uuid
 * @property string $characteristic_type
 * @property string $characteristic_uuid
 * @property string $currency_uuid
 * @property int $price
 * @property int|null $discount percentage
 * @property int $viewed_count
 * @property string $description
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCharacteristicType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCharacteristicUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCurrencyUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViewedCount($value)
 * @mixin \Eloquent
 * @property int|null $discount_percentage
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Currency $currency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $medias
 * @property-read int|null $medias_count
 * @property-read \App\Models\File|null $cover
 */
class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'uuid',
        'title',
        'category_uuid',

        'characteristic_type',
        'characteristic_uuid',

        'currency_uuid',
        'price',
        'discount_percentage',
        'viewed_count',
        'description',
        'is_active',
    ];

    protected $primaryKey = 'uuid';

    protected $casts = [
        'discount_percentage' => 'integer',
        'is_active' => 'boolean',
        // 'created_at' => 'timestamp',
        // 'updated_at' => 'timestamp',
    ];

    public function discountPrice(): Attribute
    {
        return Attribute::make(
            get: fn (): int => ($discount = $this->attributes['discount_percentage']) > 0 ? ($this->attributes['price'] / 100) * $discount : 0
        );
    }

    public function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) $this->attributes['discount_percentage'],
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_uuid', 'uuid');
    }

    public function cover(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable', 'fileable_type', 'fileable_uuid', 'uuid');
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_uuid', 'uuid');
    }

}
