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
            $table->foreignId('tenant_id')->constrained()->OnDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->OnDelete('setnull');
            $table->string('specialization');
            $table->string('license_number')->unique();
            $table->string('phone');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
            //indexing for high performance tenant-base lookup
            $table->index(['tenant_id','status']);
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
