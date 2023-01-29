<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('devices', static function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('device_able_id');
            $table->string('device_able_type');

            $table->string('refresh_token')->unique();
            $table->string('device_id');
            $table->string('device_name');
            $table->string('user_agent')->nullable();
            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->string('ip_address', 20)->nullable();
            $table->string('location', 255)->nullable();
            $table->timestamp('expired_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
