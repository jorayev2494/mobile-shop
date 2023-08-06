<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->foreignUuid('client_uuid')->references('uuid')->on('clients')->cascadeOnDelete();
            $table->string('status', 10);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
