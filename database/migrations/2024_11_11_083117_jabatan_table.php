<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('m_jabatan', function (Blueprint $table) {
            $table->id('jabatan_id');
            $table->string('jabatan_name');
            $table->string('jabatan_code')->unique();
            $table->float('point');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down() {
        Schema::dropIfExists('m_jabatan');
    }
};
