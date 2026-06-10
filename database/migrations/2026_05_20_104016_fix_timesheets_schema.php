<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::dropIfExists('timesheets_b3_daily'); // Hapus tabel lama yang tidak lengkap
        Schema::create('timesheets_b3_daily', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->date('tanggal_kegiatan');
            $table->string('project');
            $table->string('lokasi');
            $table->integer('total_jam');
            $table->string('claim_type');
            $table->text('aktivitas');
            $table->string('status_approval')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
