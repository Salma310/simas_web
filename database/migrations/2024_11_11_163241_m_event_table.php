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
            $table->id('event_id');
            $table->string('event_name');
            $table->text('event_description');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('status', ['not started', 'progress', 'completed']);
            $table->string('assign_letter');
            $table->unsignedBigInteger('jenis_event_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('jenis_event_id')->references('jenis_event_id')->on('t_jenis_event');
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
