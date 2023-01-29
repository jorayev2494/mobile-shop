<?php

declare(strict_types=1);

namespace App\Models\Auth;

use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class JWTAuth extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    // public function getJWTCustomClaims(): array
    // {
    //     return [
    //         'testKey' => 'testValue',
    //     ];
    // }
}
