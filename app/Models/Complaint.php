<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';
    protected $fillable = ['tracking_id', 'classification', 'user_id', 'judul_laporan', 'deskripsi_laporan', 'date', 'instansi_tujuan', 'status', 'kategori_laporan', 'bukti'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

