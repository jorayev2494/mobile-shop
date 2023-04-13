<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->foreignUuid('client_uuid')->references('uuid')->on('clients');

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // $table->uuid('country_uuid');
            $table->foreignUuid('country_uuid')->references('uuid')->on('countries');

            $table->string('street');
            $table->text('description')->nullable();
            $table->string('status');

            $table->integer('quality');
            $table->integer('sum');
            $table->integer('discard_sum');

            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};