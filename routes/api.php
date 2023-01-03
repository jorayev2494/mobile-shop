<?php

use Illuminate\Support\Facades\Route;

Route::get('/ping', static fn (): array => ['message' => 'pong']);
