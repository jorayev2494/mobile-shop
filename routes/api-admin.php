<?php

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\Auth\AuthController;
use App\Http\Controllers\Api\Admin\Auth\Restore\RestorePasswordController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(static function (Router $router): void {
    $router->post('/register', [AuthController::class, 'register'])->name('register');
    $router->post('/login', [AuthController::class, 'login'])->name('login');
    $router->post('/refresh-token', [AuthController::class, 'refreshToken'])->name('refresh-token');
    $router->post('/logout', [AuthController::class, 'logout'])->name('logout');

    $router->group(['prefix' => 'restore-password', 'as' => 'restore_password.'], static function (Router $router): void {
        $router->post('/link', [RestorePasswordController::class, 'link'])->name('link');
        $router->put('/restore', [RestorePasswordController::class, 'restore'])->name('restore');
    });
});

Route::group([
    // 'middleware' => 'auth:admin'
], static function (Router $router): void {
    $router->group(['prefix' => 'profile', 'controller' => ProfileController::class, 'as' => 'profile.'], static function (Router $router): void {
        $router->get('/', 'show')->name('show');
        $router->post('/', 'update')->name('update');
        $router->put('/', 'changePassword')->name('change_password');
    });

    $router->apiResource('/roles', RoleController::class);
    $router->apiResource('/categories', CategoryController::class);
    $router->apiResource('/products', ProductController::class);
});

Route::get('/ping', static fn (): array => ['message' => 'pong'])->name('ping');
