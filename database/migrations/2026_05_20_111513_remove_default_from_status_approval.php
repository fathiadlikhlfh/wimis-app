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
        Schema::table('timesheets_b3_daily', function (Blueprint $table) {
            // Mengubah status_approval agar tidak ada default value
            $table->string('status_approval')->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_approval', function (Blueprint $table) {
            //
        });
    }
};
