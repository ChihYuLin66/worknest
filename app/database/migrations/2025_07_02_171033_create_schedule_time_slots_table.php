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
        Schema::create('schedule_time_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_detail_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('schedule_detail_id')->references('id')->on('schedule_details')->onDelete('cascade');
            $table->index(['schedule_detail_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_time_slots');
    }
};
