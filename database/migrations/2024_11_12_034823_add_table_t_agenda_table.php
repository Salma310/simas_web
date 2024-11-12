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
        Schema::create('t_agenda', function (Blueprint $table) {
            $table->id('agenda_id');
            $table->unsignedBigInteger('event_id');
            $table->string('nama_agenda');
            $table->dateTime('waktu');
            $table->string('tempat');
            $table->float('point_beban_kerja');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('event_id')->references('event_id')->on('m_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_agenda');
    }
};
