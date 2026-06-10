<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimesheetB3 extends Model
{

    protected $table = 'timesheets_b3_daily';

    protected $fillable =[
        'user_id',
        'tanggal_kegiatan',
        'project',
        'jam_mulai',
        'jam_selesai',
        'aktivitas',
        'lokasi',
        'total_jam',
        'claim_type',   
        'uang_makan',
        'perdiem_type',
        'status_approval',
        'rejection_reason',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}