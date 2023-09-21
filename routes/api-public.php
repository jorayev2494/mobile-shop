<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Client\Product\IndexProductController;
use App\Http\Controllers\Api\Client\Product\ShowProductController;
use App\Http\Controllers\Api\Client\Country\IndexCountryController;

Route::group(['prefix' => 'products', 'as' => 'products.'], static function (Router $router): void {
    $router->get('/', IndexProductController::class);
    $router->get('/{uuid}', ShowProductController::class);
});

Route::group(['prefix' => 'countries', 'as' => 'countries.'], static function (Router $router): void {
    $router->get('/', IndexCountryController::class);
});

Route::get('/ping', static fn (): array => ['message' => 'pong']);
