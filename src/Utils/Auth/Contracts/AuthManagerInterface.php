<?php

declare(strict_types=1);

namespace Project\Utils\Auth\Contracts;

use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Client;
use App\Models\Enums\AppGuardType;
use Project\Domains\Client\Authentication\Domain\Member;

interface AuthManagerInterface
{
    public function auth(AppGuardType $guard = null): ?AuthModel;

    public function admin(): ?Admin;

    public function client(): ?Member;

    public function uuid(AppGuardType $guard = null): ?string;

    public function check(AppGuardType $guard = null): bool;

    public function guest(AppGuardType $guard = null): bool;

}
