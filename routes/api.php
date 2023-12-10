<?php

use App\Http\Controllers\Api\Client\Authentication\LogoutController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Client\Address\{
    IndexAddressController,
    CreateAddressController,
    ShowAddressController,
    UpdateAddressController,
    DeleteAddressController,
};
use App\Http\Controllers\Api\Client\Authentication\LoginController;
use App\Http\Controllers\Api\Client\Authentication\RefreshTokenController;
use App\Http\Controllers\Api\Client\Authentication\RegisterController;
use App\Http\Controllers\Api\Client\Authentication\Restore\RestoreCodePasswordController;
use App\Http\Controllers\Api\Client\Authentication\Restore\RestorePasswordController;
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
    OperatorCartProductController,
    DeleteProductFromCartController,
    ConfirmController,
};
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

use App\Http\Controllers\Api\Client\Profile\{
    ShowProfileController,
    UpdateProfileController,
};

// /** @var Illuminate\Routing\Router $router */
Route::prefix('auth')->name('auth.')->group(static function (Router $router): void {
    $router->post('/register', RegisterController::class)->name('register');
    $router->post('/login', LoginController::class)->name('login');
    $router->post('/refresh-token', RefreshTokenController::class)->name('refresh-token');
    $router->post('/logout', LogoutController::class)->name('logout');

    $router->group(['prefix' => 'restore-password', 'as' => 'restore_password.'], static function (Router $router): void {
        $router->post('/code', RestoreCodePasswordController::class)->name('code');
        $router->put('/restore', RestorePasswordController::class)->name('restore');
    });
});

Route::group(['middleware' => 'auth:client'], static function (Router $router): void {
    $router->group(['prefix' => 'profile', 'as' => 'profile.'], static function (Router $router): void {
        $router->get('/', ShowProfileController::class);
        $router->post('/', UpdateProfileController::class);
    });

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
        $router->post('/confirm', ConfirmController::class);

        $router->group(['prefix' => 'products', 'as' => 'products.'], static function (Router $router): void {
            $router->post('/', AddProductController::class);
            $router->put('/{product_uuid}', OperatorCartProductController::class);
            $router->delete('/{product_uuid}', DeleteProductFromCartController::class);
        });
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
