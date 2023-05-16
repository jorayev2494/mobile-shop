<?php

use App\Http\Controllers\Api\Client\Auth\AuthController;
use App\Http\Controllers\Api\Client\Auth\Restore\RestorePasswordController;

use App\Http\Controllers\Api\Client\{
    AddressController,
    CardController,
    FavoriteController,
    OrderController,
    ProductController,
};

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// /** @var Illuminate\Routing\Router $router */
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

Route::group(['as' => 'products'], static function (Router $router): void {
    $router->get('/products', [ProductController::class, 'index']);
    $router->get('/products/{uuid}', [ProductController::class, 'show']);
});

Route::group(['middleware' => 'auth:client'], static function (Router $router): void {
    $router->apiResource('/cards', CardController::class);
    $router->apiResource('/addresses', AddressController::class);
    $router->apiResource('/orders', OrderController::class);
    $router->group(['prefix' => 'favorites', 'controller' => FavoriteController::class], static function (Router $router): void {
        $router->get('/', 'index');
        $router->put('/{product_uuid}', 'toggle');
    });
});

Route::get('/ping', static fn (): array => ['message' => 'pong']);
