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
        Schema::create('t_workload', function (Blueprint $table) {
            $table->id('workload_id');
            $table->unsignedBigInteger('agenda_id');
            $table->unsignedBigInteger('user_id');
            $table->float('earned_points');
            $table->string('period');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('agenda_id')->references('agenda_id')->on('t_agenda');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_workload');
    }
};
