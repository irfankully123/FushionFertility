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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('appointment_reason');
            $table->string('day');
            $table->enum('status', ['Pending','Meeting', 'Paid', 'Completed'])->default('Pending');
            $table->dateTime('meeting_end_time')->nullable();
            $table->text('zoom_start_url')->nullable();
            $table->text('zoom_join_url')->nullable();
            $table->text('prescription_description')->nullable();
            $table->string('prescription_image_url')->nullable();
            $table->string('prescription_pdf_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
