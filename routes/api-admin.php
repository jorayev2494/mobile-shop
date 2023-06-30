<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Profile\ProfileController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\Auth\AuthController;
use App\Http\Controllers\Api\Admin\Auth\Restore\RestorePasswordController;
use App\Http\Controllers\Api\Admin\Category\CreateCategoryController;
use App\Http\Controllers\Api\Admin\Category\DeleteCategoryController;
use App\Http\Controllers\Api\Admin\Category\GetCategoryController;
use App\Http\Controllers\Api\Admin\Category\ShowCategoryController;
use App\Http\Controllers\Api\Admin\Category\UpdateCategoryController;
use App\Http\Controllers\Api\Admin\Country\CreateCountryController;
use App\Http\Controllers\Api\Admin\Country\DeleteCountryController;
use App\Http\Controllers\Api\Admin\Country\IndexCountryController;
use App\Http\Controllers\Api\Admin\Country\ShowCountryController;
use App\Http\Controllers\Api\Admin\Country\UpdateCountryController;
use App\Http\Controllers\Api\Admin\Order\GetOrderController;
use App\Http\Controllers\Api\Admin\Order\ShowOrderController;
use App\Http\Controllers\Api\Admin\Order\UpdateOrderController;
use App\Http\Controllers\Api\Admin\Product\{GetProductController, CreateProductController, ShowProductController, UpdateProductController, DeleteProductController,};
use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:admin'], static function (Router $router): void {
    $router->group(['prefix' => 'profile', 'controller' => ProfileController::class, 'as' => 'profile.'], static function (Router $router): void {
        $router->get('/', 'show')->name('show');
        $router->post('/', 'update')->name('update');
        $router->put('/', 'changePassword')->name('change_password');
    });

    $router->apiResource('/roles', RoleController::class);

    $router->group(['prefix' => 'categories', 'as' => 'categories.'], static function (Router $router): void {
        $router->get('/', GetCategoryController::class);
        $router->post('/', CreateCategoryController::class);
        $router->get('/{uuid}', ShowCategoryController::class);
        $router->put('/{uuid}', UpdateCategoryController::class);
        $router->delete('/{uuid}', DeleteCategoryController::class);
    });

    $router->group(['prefix' => 'countries', 'as' => 'countries.'], static function (Router $router): void {
        $router->get('/', IndexCountryController::class);
        $router->post('/', CreateCountryController::class);
        $router->get('/{uuid}', ShowCountryController::class);
        $router->put('/{uuid}', UpdateCountryController::class);
        $router->delete('/{uuid}', DeleteCountryController::class);
    });

    $router->group(['prefix' => 'products', 'as' => 'products.'], static function (Router $router): void {
        $router->get('/', GetProductController::class);
        $router->post('/', CreateProductController::class);
        $router->get('/{uuid}', ShowProductController::class);
        $router->post('/{uuid}', UpdateProductController::class);
        $router->delete('/{uuid}', DeleteProductController::class);
    });

    $router->group(['prefix' => 'orders', 'as' => 'orders.'], static function (Router $router): void {
        $router->get('/', GetOrderController::class);
        $router->get('/{uuid}', ShowOrderController::class);
        $router->put('/{uuid}', UpdateOrderController::class);
    });
});

// Route::post('/dropzone', function (Request $request): array {
//     dd($request->all());

//     return [];
// });

Route::get('/ping', static fn (): array => ['message' => 'pong'])->name('ping');
