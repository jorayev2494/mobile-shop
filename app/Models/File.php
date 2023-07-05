<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\File
 *
 * @property string $uuid
 * @property int|null $fileable_id
 * @property string|null $fileable_type
 * @property int|null $width
 * @property int|null $height
 * @property string $path
 * @property string $mime_type
 * @property string $type
 * @property string $extension
 * @property string $size
 * @property string|null $file_name
 * @property string $file_original_name
 * @property string $name
 * @property string $full_path
 * @property string $url
 * @property int $downloaded_count
 * @property string $disk
 * @property bool $is_public
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FileFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereDownloadedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFullPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereWidth($value)
 * @mixin \Eloquent
 * @property string|null $fileable_uuid
 * @property-read Model|\Eloquent $fileable
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableUuid($value)
 */
class File extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'uuid',
        'fileable_uuid',
        'fileable_type',
        'width',
        'height',
        'path',
        'mime_type',
        'type',
        'extension',
        'size',
        'file_name',
        'file_original_name',
        'name',
        'full_path',
        'url',
        'disk',
        'downloaded_count',
        'is_public',
        'is_active',
        'created_at',
    ];

    protected $primaryKey = 'uuid';

    public $casts = [
        'is_public' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $hidden = [
        'fileable_uuid',
        'fileable_type',
        'url',
        'disk',
        'is_public',
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'fileable_type', 'fileable_uuid');
    }
}
