<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_product', static function (Blueprint $table): void {
            $table->id();

            $table->foreignUuid('cart_uuid')->references('uuid')->on('carts');
            $table->foreignUuid('product_uuid')->references('uuid')->on('products');

            $table->foreignUuid('cart_currency_uuid')->references('uuid')->on('currencies');
            $table->integer('cart_quality');
            $table->integer('cart_price');
            $table->integer('cart_discount_percentage')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
