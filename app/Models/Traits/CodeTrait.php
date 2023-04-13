<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Code;
use App\Models\Enums\AppGuardType;
use App\Models\Enums\CodeType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CodeTrait
{
    public function codes(): MorphMany
    {
        return $this->morphMany(Code::class, 'code_able', 'code_able_type', 'code_able_id');
    }

    public function generateToken(CodeType $type, AppGuardType $guard = null): Code
    {
        $token = md5((string) microtime());

        return $this->generateTokenOrCode($type, (string) $token, guard: $guard);
    }

    public function generateCode(CodeType $type, AppGuardType $guard = null): Code
    {
        $code = random_int(000000, 999999);

        return $this->generateTokenOrCode($type, (string) $code, 'value', $guard);
    }

    private function generateTokenOrCode(CodeType $type, string $value, string $tokenOrCodeKey = 'token', AppGuardType $guard = null): Code
    {
        return $this->codes()->updateOrCreate([
            'type' => $type,
        ],
            [
                'type' => $type,
                'expired_at' => now()->addHour(),
                'guard' => $guard,
                $tokenOrCodeKey => $value,
            ]
        );
    }
}
