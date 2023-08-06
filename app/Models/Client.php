<?php

namespace App\Models;

use App\Models\Auth\AuthModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Code[] $codes
 * @property-read int|null $codes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUuid($value)
 * @property string $country_uuid
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCountryUuid($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $favorites
 * @property-read int|null $favorites_count
 * @property string $phone
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cards
 * @property-read int|null $cards_count
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhone($value)
 * @property-read \App\Models\File|null $avatar
 * @property-read string $full_name
 */
class Client extends AuthModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'country_uuid',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function getJWTCustomClaims(): array
    {
        return [
            'testKey' => 'testValue',
            'model' => self::class,
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_uuid', 'uuid');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, FavoriteClient::class, 'client_uuid', 'product_uuid');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'client_uuid', 'uuid');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'client_uuid', 'uuid');
    }
}
