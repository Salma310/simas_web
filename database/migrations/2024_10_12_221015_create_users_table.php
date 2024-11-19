<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('role_id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('phone');
            $table->string('picture')->default('images/default.jpg');
            $table->string('auth_token')->default('');  // default string kosong
            $table->string('device_token')->default('');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        $table->foreign('role_id')->references('role_id')->on('m_role');
        
        });
    }

    public function down() {
        Schema::dropIfExists('m_user');
    }
};
