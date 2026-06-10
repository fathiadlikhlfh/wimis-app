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
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('type'); // 'Form A' atau 'Form B'
            $table->date('tanggal');
            $table->string('project');
            $table->string('lokasi');
            $table->integer('total_jam');
            $table->string('claim_type'); // Perdiem, Uang Makan, dll
            $table->text('kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets_tables');
    }
};
