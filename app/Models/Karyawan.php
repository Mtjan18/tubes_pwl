<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $primaryKey = 'nip';

    public $incrementing = false; // Karena nip bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nip',
        'program_studi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id_program_studi');
    }
}
