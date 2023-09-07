<?php

namespace Project\Utils\Auth\Contracts;

use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Client;
use App\Models\Enums\AppGuardType;

interface AuthManagerInterface
{
    public function auth(AppGuardType $guard = null): ?AuthModel;

    public function admin(): ?Admin;

    public function client(): ?Client;

    public function uuid(AppGuardType $guard = null): ?string;

    public function check(AppGuardType $guard = null): bool;

    public function guest(AppGuardType $guard = null): bool;

}
