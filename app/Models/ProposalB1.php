<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalB1 extends Model
{
    protected $table = 'proposals_b1';

    protected $fillable =[
        'user_id', 
        'judul_kegiatan', 
        'project_code', 
        'lokasi', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'deskripsi', 
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
