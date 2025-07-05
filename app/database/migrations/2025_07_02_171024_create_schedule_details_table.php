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
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_plan_id');
            $table->unsignedBigInteger('employee_id');
            $table->date('shift_date');
            $table->unsignedBigInteger('shift_type_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_minutes');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->foreign('schedule_plan_id')->references('id')->on('schedule_plans')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('shift_type_id')->references('id')->on('shift_types')->onDelete('cascade');
            
            $table->index(['schedule_plan_id']);
            $table->index(['employee_id']);
            $table->index(['shift_date']);
            $table->index(['shift_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_details');
    }
};
