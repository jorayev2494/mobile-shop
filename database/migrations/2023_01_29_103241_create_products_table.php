<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->string('title');

            // $table->uuid('category_uuid');
            $table->foreignUuid('category_uuid')->references('uuid')->on('categories');

            // $table->uuidMorphs('characteristic');
            // $table->string("characteristic_type");
            // $table->uuid("characteristic_uuid");

            $table->foreignUuid('currency_uuid')->references('uuid')->on('currencies');
            $table->integer('price');
            $table->integer('discount_percentage')->nullable();

            $table->integer('viewed_count')->default(0);
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
