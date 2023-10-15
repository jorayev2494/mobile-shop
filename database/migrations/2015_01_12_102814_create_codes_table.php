<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('codes', static function (Blueprint $table): void {
            $table->id();

            $table->string('code_able_uuid');
            $table->string('code_able_type');

            $table->string('type')->nullable();
            $table->integer('value')->nullable()->unique();
            $table->string('token')->nullable()->unique();
            $table->string('guard')->nullable();
            $table->timestamp('expired_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
