<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKM extends Model
{
    protected $table = 'data_km';
    
    protected $fillable =[
        'judul', 
        'kategori', 
        'nama_penulis', 
        'tanggal_laporan', 
        'lokasi', 
        'project', 
        'file_path', 
        'ringkasan'
    ];
}