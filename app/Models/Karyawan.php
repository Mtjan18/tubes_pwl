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
        'user_id', 'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
