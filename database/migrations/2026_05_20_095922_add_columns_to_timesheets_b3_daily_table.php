<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('timesheets_b3_daily', function (Blueprint $table) {
            $table->string('lokasi')->after('id');
            $table->string('project')->after('lokasi');
            $table->integer('total_jam')->after('project');
            $table->string('claim_type')->after('total_jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timesheets_b3_daily', function (Blueprint $table) {
            //
        });
    }
};
