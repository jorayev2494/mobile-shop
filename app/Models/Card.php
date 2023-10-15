<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Card
 *
 * @method static \Database\Factories\CardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Card query()
 * @mixin \Eloquent
 * @property string $uuid
 * @property string $client_uuid
 * @property string $type
 * @property string $card_holder_name
 * @property string $card_number
 * @property string $cvv
 * @property string $expiration_date
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereClientUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereUuid($value)
 * @property string $holder_name
 * @property string $number
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereHolderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Card whereNumber($value)
 * @property-read \App\Models\Client $client
 */
class Card extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'client_uuid',
        'type',
        'holder_name',
        'number',
        'cvv',
        'expiration_date',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_uuid', 'uuid');
    }
}
