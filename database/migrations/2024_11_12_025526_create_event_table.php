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
        Schema::create('m_event', function (Blueprint $table) {
            $table->id();
            $table->string('event_kode', 20)->nullable(false)->unique();
            $table->string('event_jenis', 100)->nullable();
            $table->string('event_name', 200)->nullable(false);
            $table->string('event_deskripsi', 255)->nullable();
            $table->string('surat_tugas', 255)->nullable();
            $table->string('pic', 200)->nullable();
            $table->string('status', 200)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_event');
    }
};
