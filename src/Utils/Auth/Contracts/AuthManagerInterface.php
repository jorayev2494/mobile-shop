<?php

namespace Project\Utils\Auth\Contracts;

use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Client;
use Project\Utils\Auth\AuthGuard;

interface AuthManagerInterface // extends Guard
{
    // public function guard(?string $name = null) : \Illuminate\Contracts\Auth\StatefulGuard;

    public function auth(AuthGuard $authGuard = null): ?AuthModel;

    public function admin(): ?Admin;

    public function client(): ?Client;

    public function check(): bool;

    public function guest(): bool;

}
