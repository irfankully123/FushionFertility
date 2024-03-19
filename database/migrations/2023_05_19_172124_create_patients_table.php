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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-','O+','O-','AB+','AB-'])->nullable();
            $table->enum('gender', ['M','F']);
            $table->date('dob')->nullable(); //date of birth
            $table->integer('age')->nullable();
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('contact');
            $table->string('primary_care_physician')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('current_medications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
