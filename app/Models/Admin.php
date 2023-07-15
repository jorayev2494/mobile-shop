<?php

namespace App\Models;

use App\Http\Resources\RoleResource;
use App\Models\Auth\AuthModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read int|null $devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\AdminFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Code[] $codes
 * @property-read int|null $codes_count
 * @property string|null $avatar
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAvatar($value)
 * @property string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUuid($value)
 */
class Admin extends AuthModel
{
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'role_id',
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
            'model' => self::class,
            'role' => RoleResource::make($this->role()->with('permissions')->first()),
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
