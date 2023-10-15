<?php

declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Tymon\JWTAuth\JWTGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // https://code.tutsplus.com/tutorials/how-to-create-a-custom-authentication-guard-in-laravel--cms-29667
        JWTGuard::macro(
            'admin',
            fn (): ?Admin => App::make('auth')->guard(AppGuardType::ADMIN->value)->user()
        );

        JWTGuard::macro(
            'client',
            fn (): ?Client => App::make('auth')->guard(AppGuardType::CLIENT->value)->user()
        );

        //
    }
}
