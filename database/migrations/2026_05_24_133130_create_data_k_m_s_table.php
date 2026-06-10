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
        Schema::create('data_km', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori'); // Riset, Laporan, Pembelajaran, dll
            $table->string('nama_penulis');
            $table->date('tanggal_laporan');
            $table->string('lokasi');
            $table->string('project');
            $table->string('file_path'); 
            $table->text('ringkasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_k_m_s');
    }
};
