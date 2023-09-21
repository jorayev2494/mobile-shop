<?php

namespace App\Providers;

use App\Enums\RoutePattern;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '';

    /** @var array<string, RoutePattern> */
    private const ROUTE_PATTERNS = [
        'id' => RoutePattern::INTEGER,
        'uuid' => RoutePattern::UUID,
    ];

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->registerRoutePatterns();
        $this->routes(function (): void {
            $this->registerAdminAPIRoutes();
            $this->registerAPIRoutes();
            $this->registerWebRoutes();
            $this->registerPublicAPIRoutes();
        });
    }

    private function registerAdminAPIRoutes(): void
    {
        Route::middleware('api')
                ->prefix('api/admin')
                ->name('admin.')
                ->group(
                    base_path('routes/api-admin.php')
                );
    }

    private function registerAPIRoutes(): void
    {
        Route::middleware('api')
                ->prefix('api')
                ->group(
                    base_path('routes/api.php')
                );
    }

    private function registerPublicAPIRoutes(): void
    {
        Route::middleware('api')
                ->prefix('api/')
                ->group(
                    base_path('routes/api-public.php')
                );
    }

    private function registerWebRoutes(): void
    {
        Route::middleware('web')
                ->group(base_path('routes/web.php'));
    }

    private function registerRoutePatterns(): void
    {
        foreach (self::ROUTE_PATTERNS as $key => $pattern) {
            Route::pattern($key, $pattern->value);
        }
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
