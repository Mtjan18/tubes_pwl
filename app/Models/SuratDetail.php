<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDetail extends Model
{
    use HasFactory;

    protected $table = 'surat_detail';
    protected $fillable = [
        'surat_id',
        'status',
        'alasan_penolakan',
        'approved_by',
        'processed_by'
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
