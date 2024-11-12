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
        Schema::create('agenda_documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->unsignedBigInteger('agenda_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('upload_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('agenda_id')->references('agenda_id')->on('t_agenda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_documents');
    }
};
