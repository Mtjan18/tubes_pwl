<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'nrp';

    public $incrementing = false; // Karena nrp bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'nrp', 'user_id', 'program_studi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
