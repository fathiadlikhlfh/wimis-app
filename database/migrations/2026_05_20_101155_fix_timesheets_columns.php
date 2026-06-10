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
        Schema::table('timesheets_b3_daily', function (Blueprint $table) {
            // Jika kolom 'tanggal' belum ada, kita rename atau tambahkan
            // Kita gunakan 'tanggal_kegiatan' agar konsisten dengan migrasi awal
            if (!Schema::hasColumn('timesheets_b3_daily', 'tanggal_kegiatan')) {
                $table->date('tanggal_kegiatan')->nullable();
            }
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
