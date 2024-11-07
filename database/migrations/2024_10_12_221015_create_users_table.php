<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('role_id')->index()->nullable(false);
            $table->string('username', 20)->nullable(false)->unique();
            $table->string('email', 200)->nullable();
            $table->string('password', 100)->nullable(false);
            $table->string('auth_token', 100)->nullable()->unique();
            $table->string('device_token', 100)->nullable()->unique();
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('m_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
