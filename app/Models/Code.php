<?php

namespace App\Models;

use App\Models\Auth\AuthModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Code
 *
 * @property-read Model|AuthModel|\Eloquent $codeAble
 * @method static \Illuminate\Database\Eloquent\Builder|Code newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Code newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Code query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $code_able_id
 * @property string $code_able_type
 * @property string|null $type
 * @property int|null $value
 * @property string|null $token
 * @property string|null $guard
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCodeAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCodeAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereGuard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereValue($value)
 * @property string $code_able_uuid
 * @method static \Illuminate\Database\Eloquent\Builder|Code whereCodeAbleUuid($value)
 */
class Code extends Model
{
    /**
     * @var array
     */
    public $fillable = [
        'user_id',
        'code_able_uuid',
        'code_able_type',
        'type',
        'value',
        'token',
        'expired_at',
        'guard',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return MorphTo
     */
    public function codeAble(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'code_able_type', 'code_able_uuid');
    }
}
