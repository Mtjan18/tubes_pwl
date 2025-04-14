<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama default
    protected $table = 'program_studi';

    // Tentukan primary key tabel
    protected $primaryKey = 'id_program_studi';

    // Set apakah primary key menggunakan auto-increment
    public $incrementing = false;

    // Tentukan tipe primary key
    protected $keyType = 'string';

    // Kolom yang dapat diisi massal
    protected $fillable = [
        'id_program_studi', 'nama_program_studi',
    ];

    // Relasi dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'program_studi_id', 'id_program_studi');
    }
}

