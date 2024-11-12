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
        Schema::create('t_notification', function (Blueprint $table) {
            $table->id('notification_id');
            // Menghapus kolom 'user_id' dan 'agenda_id'
            $table->unsignedBigInteger('event_id')->nullable();
            $table->string('title');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Menambahkan foreign key hanya untuk 'event_id'
            $table->foreign('event_id')->references('event_id')->on('m_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_notification');
    }
};
