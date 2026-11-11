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
        Schema::table('users', function (Blueprint $table) {

            //Enforce specifice strict roles for clinic compliance
              $table->string('role')->default('clinic_amin')->after('tenant_id');
             //Add indexing for rapid authorization verification queries
            $table->index(['tenant_id','role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['tenant_id','role']);
            $table->dropColumn(['role']);
        });
    }
};
