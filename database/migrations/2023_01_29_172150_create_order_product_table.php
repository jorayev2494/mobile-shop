<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_product', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->foreignUuid('order_uuid')->references('uuid')->on('orders');
            $table->foreignUuid('product_uuid')->references('uuid')->on('products');

            $table->integer('quality');
            $table->integer('sum');
            $table->integer('discard_sum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
