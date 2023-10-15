<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Profile\ProfileController;
use App\Http\Controllers\Api\Admin\Authentication\{RegisterController, LoginController, RefreshTokenController, LogoutController,};
use App\Http\Controllers\Api\Admin\Authentication\Restore\{RestorePasswordLinkController, RestorePasswordController,};
use App\Http\Controllers\Api\Admin\Order\{GetOrderController, ShowOrderController, UpdateOrderController,};
use App\Http\Controllers\Api\Admin\Category\{CreateCategoryController, DeleteCategoryController, GetCategoryController, ShowCategoryController, UpdateCategoryController,};
use App\Http\Controllers\Api\Admin\Client\{IndexClientController, CreateClientController, ShowClientController, UpdateClientController, DeleteClientController,};
use App\Http\Controllers\Api\Admin\Currency\IndexCurrencyController;
use App\Http\Controllers\Api\Admin\Country\{CreateCountryController, DeleteCountryController, IndexCountryController, ShowCountryController, UpdateCountryController,};
use App\Http\Controllers\Api\Admin\Currency\CreateCurrencyController;
use App\Http\Controllers\Api\Admin\Currency\DeleteCurrencyController;
use App\Http\Controllers\Api\Admin\Currency\ShowCurrencyController;
use App\Http\Controllers\Api\Admin\Currency\UpdateCurrencyController;
use App\Http\Controllers\Api\Admin\Manager\{DeleteManagerController, ShowManagerController, UpdateManagerController, CreateManagerController, IndexManagerController,};
use App\Http\Controllers\Api\Admin\Product\{GetProductController, CreateProductController, ShowProductController, UpdateProductController, DeleteProductController,};
use App\Http\Controllers\Api\Admin\Role\{CreateRoleController, DeleteRoleController, IndexPermissionController, IndexRoleController, ShowRoleController, UpdateRoleController,};

Route::prefix('auth')->name('auth.')->group(static function (Router $router): void {
    $router->post('/register', RegisterController::class)->name('register');
    $router->post('/login', LoginController::class)->name('login');
    $router->post('/refresh-token', RefreshTokenController::class)->name('refresh-token');
    $router->post('/logout', LogoutController::class)->name('logout');

    $router->group(['prefix' => 'restore-password', 'as' => 'restore_password.'], static function (Router $router): void {
        $router->post('/link', RestorePasswordLinkController::class)->name('link');
        $router->put('/restore', RestorePasswordController::class)->name('restore');
    });
});

Route::group(['middleware' => 'auth:admin'], static function (Router $router): void {
    $router->group(['prefix' => 'profile', 'controller' => ProfileController::class, 'as' => 'profile.'], static function (Router $router): void {
        $router->get('/', 'show')->name('show');
        $router->post('/', 'update')->name('update');
        $router->put('/change-password', 'changePassword')->name('change_password');
    });

    $router->group(['prefix' => 'managers', 'as' => 'admins.'], static function (Router $router): void {
        $router->get('/', IndexManagerController::class);
        $router->post('/', CreateManagerController::class);
        $router->get('/{uuid}', ShowManagerController::class);
        $router->post('/{uuid}', UpdateManagerController::class);
        $router->delete('/{uuid}', DeleteManagerController::class);
    });

    $router->group(['prefix' => 'clients', 'as' => 'clients.'], static function (Router $router): void {
        $router->get('/', IndexClientController::class);
        $router->post('/', CreateClientController::class);
        $router->get('/{uuid}', ShowClientController::class);
        $router->put('/{uuid}', UpdateClientController::class);
        $router->delete('/{uuid}', DeleteClientController::class);
    });

    $router->group(['prefix' => 'roles', 'as' => 'roles.'], static function (Router $router): void {
        $router->get('/', IndexRoleController::class);
        $router->post('/', CreateRoleController::class);
        $router->get('/{id}', ShowRoleController::class);
        $router->put('/{id}', UpdateRoleController::class);
        $router->delete('/{id}', DeleteRoleController::class);

        $router->group(['prefix' => 'permissions', 'as' => 'permissions.'], static function (Router $router): void {
            $router->get('/', IndexPermissionController::class);
        });
    });

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

    $router->group(['prefix' => 'currencies', 'as' => 'currencies.'], static function (Router $router): void {
        $router->get('/', IndexCurrencyController::class);
        $router->post('/', CreateCurrencyController::class);
        $router->get('/{uuid}', ShowCurrencyController::class);
        $router->put('/{uuid}', UpdateCurrencyController::class);
        $router->delete('/{uuid}', DeleteCurrencyController::class);
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

Route::get('/ping', static fn (): array => ['message' => 'pong'])->name('ping');
