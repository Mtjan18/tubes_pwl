<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'jenis_surat_id',
        'nama',
        'semester',
        'keperluan',
        'ditujukan_ke',
        'nama_matkul',
        'data_mahasiswa',
        'topik',
        'tujuan_topik',
        'tgl_lulus',
        'user_id',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function suratDetail()
    {
        return $this->hasOne(SuratDetail::class, 'surat_id');
    }
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id', 'user_id');
    }

}
