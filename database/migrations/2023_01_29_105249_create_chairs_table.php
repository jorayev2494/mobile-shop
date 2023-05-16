<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chairs', static function (Blueprint $table): void {
            $table->uuid()->primary();

            // $table->stirng

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chairs');
    }
};
