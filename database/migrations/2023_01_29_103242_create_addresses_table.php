<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', static function (Blueprint $table): void {
            $table->uuid('uuid')->primary();

            
            $table->string('title');
            $table->string('full_name');
            $table->foreignUuid('client_uuid')->references('uuid')->on('clients');
            $table->string('first_address');
            $table->string('second_address')->nullable();
            $table->string('zip_code', 10);
            $table->foreignUuid('country_uuid')->references('uuid')->on('countries');
            $table->foreignUuid('city_uuid')->references('uuid')->on('cities');
            $table->string('district')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
