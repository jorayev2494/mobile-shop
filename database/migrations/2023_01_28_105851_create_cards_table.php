<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->foreignUuid('client_uuid')->references('uuid')->on('clients');
            $table->string('type', 20);
            $table->string('holder_name', 50);
            $table->string('number', 20);
            $table->string('cvv')->unsigned();
            $table->string('expiration_date');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
