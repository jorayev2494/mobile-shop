<?php

use App\Http\Controllers\Api\Admin\Auth\AuthController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(static function (Router $router): void {
    $router->post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/ping', static fn (): array => ['message' => 'pong'])->name('ping');
