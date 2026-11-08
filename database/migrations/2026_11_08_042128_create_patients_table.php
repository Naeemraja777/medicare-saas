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
            $table->foreignId('tenant_id')->constrained()->OnDelete('cascade');
            $table->string('patient_number')->unique();
            $table->string('name');
            $table->date('date_of_birth');
            $table->enum('gender',['male','female','both']);
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('medical_history')->nullable();
            $table->timestamps();
            $table->index(['tenant_id','phone']);
            $table->index(['tenant_id','patient_number']);
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
