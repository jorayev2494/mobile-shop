<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        // Schema::create('clients', static function (Blueprint $table): void {
        //     $table->uuid()->primary();

        //     $table->string('first_name')->nullable();
        //     $table->string('last_name')->nullable();
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');

        //     $table->string('phone')->nullable();
        //     $table->foreignUuid('country_uuid')->nullable()->references('uuid')->on('countries');

        //     $table->rememberToken();

        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        // Schema::dropIfExists('clients');
    }
};
