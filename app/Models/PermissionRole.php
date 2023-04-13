<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\PermissionRole
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermissionRole extends Pivot
{
    protected $table = 'permission_role';

    protected $fillable = [
        'role_id',
        'permission_id',
        'is_active',
    ];
}
