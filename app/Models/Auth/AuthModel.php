<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\Contracts\Device;
use App\Models\Traits\Avatar;
use App\Models\Traits\CodeTrait;
use App\Models\Traits\DeviceTrait;
use App\Models\Traits\RestorePasswordTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

abstract class AuthModel extends JWTAuth implements Device
{
    use HasFactory;

    // use MustVerifyEmail;
    use HasUuids;
    use Notifiable;
    use DeviceTrait;
    use CodeTrait;
    use RestorePasswordTrait;
    use Avatar;

    protected $primaryKey = 'uuid';

    public function password(): Attribute
    {
        return Attribute::make(
            set: static fn (string $value): string => Hash::make($value),
        );
    }
}
