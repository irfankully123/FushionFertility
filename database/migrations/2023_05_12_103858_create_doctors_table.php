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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('gender', ['M', 'F']); // M for Male and F for female
            $table->text('description')->nullable();
            $table->text('qualification');
            $table->text('experience');
            $table->date('dob'); // Date of birth
            $table->decimal('fee', 8, 2);
            $table->enum('is_zoom_attach',[0,1])->default(0);
            $table->enum('consultant_meeting_time',[15,20,30,60])->default(30);
            $table->text('address');
            $table->string('contact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
