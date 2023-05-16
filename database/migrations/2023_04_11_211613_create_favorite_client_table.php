<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorite_client', static function (Blueprint $table): void {
            $table->id();

            $table->foreignUuid('client_uuid')->references('uuid')->on('clients');
            $table->foreignUuid('product_uuid')->references('uuid')->on('products');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorite_client');
    }
};
