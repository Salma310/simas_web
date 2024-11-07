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
        Schema::create('m_profile', function (Blueprint $table) {
            $table->id('profile_id');
            $table->unsignedBigInteger('user_id')->index()->nullable(false);
            $table->string('name', 200)->nullable(false);
            $table->string('nidn', 20)->nullable(false)->unique();
            $table->string('phone', 100)->nullable();
            $table->string('picture', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_profile');
    }
};
