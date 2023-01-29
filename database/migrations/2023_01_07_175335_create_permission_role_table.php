<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('permission_role', static function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->bigInteger('role_id')->unsigned();
            $table->foreign('role_id')->on('roles')->references('id')->cascadeOnDelete();

            $table->bigInteger('permission_id')->unsigned();
            $table->foreign('permission_id')->on('permissions')->references('id')->cascadeOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
