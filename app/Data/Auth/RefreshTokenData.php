<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class RefreshTokenData implements MakeFromFormRequest
{
    public function __construct(
        public readonly ?string $device_id,
        public readonly ?string $refresh_token,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        return new static(
            device_id: $request->headers->get('x-device-id'),
            refresh_token: $request->get('refresh_token'),
        );
    }
}
