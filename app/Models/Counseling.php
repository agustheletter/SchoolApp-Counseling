<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counseling extends Model
{
    use HasFactory;

    protected $table = 'tbl_konseling';
    
    // Set the correct primary key based on your database schema
    protected $primaryKey = 'idkonseling';
    
    // If your primary key is not auto-incrementing, set this to false
    public $incrementing = true;
    
    // Set the key type if it's not an integer
    protected $keyType = 'int';

    protected $fillable = [
        'idkonseling', // This references the CounselingRequest id
        'idsiswa',
        'idguru',
        'tanggal_konseling',
        'hasil_konseling',
        'status',
    ];

    protected $casts = [
        'tanggal_konseling' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'idsiswa', 'id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'idguru', 'id');
    }

    public function counselingRequest()
    {
        return $this->belongsTo(CounselingRequest::class, 'idkonseling', 'id');
    }
}