<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Client\Auth\AuthController;
use App\Http\Controllers\Api\Client\Auth\Restore\RestorePasswordController;

use App\Http\Controllers\Api\Client\Address\{
    IndexAddressController,
    CreateAddressController,
    ShowAddressController,
    UpdateAddressController,
    DeleteAddressController,
};
use App\Http\Controllers\Api\Client\Card\{
    IndexCardController,
    CreateCardController,
    ShowCardController,
    UpdateCardController,
    DeleteCardController,
};
use App\Http\Controllers\Api\Client\Cart\{
    IndexCartController,
    AddProductController,
    CreateCartController,
    ShowCartController,
    DeleteProductFromCartController,
};
use App\Http\Controllers\Api\Client\Country\IndexCountryController;
use App\Http\Controllers\Api\Client\Order\{
    IndexOrderController,
    CreateOrderController,
    UpdateOrderController,
    ShowOrderController,
    DeleteOrderController,
};

use App\Http\Controllers\Api\Client\Favorite\{
    IndexFavoriteController,
    ToggleFavoriteController,
};

use App\Http\Controllers\Api\Client\Product\IndexProductController;
use App\Http\Controllers\Api\Client\Product\ShowProductController;

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

Route::group(['prefix' => 'products', 'as' => 'products'], static function (Router $router): void {
    $router->get('/', IndexProductController::class);
    $router->get('/{uuid}', ShowProductController::class);
});

Route::group(['prefix' => 'countries', 'as' => 'countries.'], static function (Router $router): void {
    $router->get('/', IndexCountryController::class);
});

Route::group(['middleware' => 'auth:client'], static function (Router $router): void {
    $router->group(['prefix' => 'cards', 'as' => 'cards.'], static function (Router $router): void {
        $router->get('/', IndexCardController::class);
        $router->post('/', CreateCardController::class);
        $router->get('/{uuid}', ShowCardController::class);
        $router->put('/{uuid}', UpdateCardController::class);
        $router->delete('/{uuid}', DeleteCardController::class);
    });

    $router->group(['prefix' => 'addresses', 'as' => 'addresses.'], static function (Router $router): void {
        $router->get('/', IndexAddressController::class);
        $router->post('/', CreateAddressController::class);
        $router->get('/{uuid}', ShowAddressController::class);
        $router->put('/{uuid}', UpdateAddressController::class);
        $router->delete('/{uuid}', DeleteAddressController::class);
    });

    $router->group(['prefix' => 'carts', 'as' => 'carts.'], static function (Router $router): void {
        $router->get('/', IndexCartController::class);
        $router->post('/', CreateCartController::class);
        $router->get('/{uuid}', ShowCartController::class);
        $router->post('/{uuid}/products', AddProductController::class);
        $router->delete('/{uuid}/products', DeleteProductFromCartController::class);
    });

    $router->group(['prefix' => 'orders', 'as' => 'orders.'], static function (Router $router): void {
        $router->get('/', IndexOrderController::class);
        $router->post('/', CreateOrderController::class);
        $router->get('/{uuid}', ShowOrderController::class);
        $router->put('/{uuid}', UpdateOrderController::class);
        $router->delete('/{uuid}', DeleteOrderController::class);
    });

    $router->group(['prefix' => 'favorites', 'as' => 'favorites.'], static function (Router $router): void {
        $router->get('/', IndexFavoriteController::class);
        $router->post('/{product_uuid}', ToggleFavoriteController::class);
    });
});

Route::get('/ping', static fn (): array => ['message' => 'pong']);
