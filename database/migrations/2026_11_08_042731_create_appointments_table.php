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
            $table->foreignId('tenant_id')->constrained()->OnDelete('cascade');
            $table->foreignId('patient_id')->constrained()->OnDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->OnDelete('cascade');
            $table->dateTime('appointment_date');
            $table->enum('status',['scheduled','completed','cancelled','no_show'])->default('scheduled');
            $table->text('symptoms_descriptions')->nullable();
            $table->text('doctor_notes')->nullable();
            $table->timestamps();
            //indexing for pulling a clinic daily calender layouts quickly
            $table->index(['tenant_id','appointment_date','status']);
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
