<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingRequest extends Model
{
    protected $table = 'tbl_konselingrequest';
    
    protected $fillable = [
        'idsiswa',
        'idguru',
        'kategori',
        'tanggal_permintaan',
        'deskripsi',
        'status'
    ];

    protected $dates = [
        'tanggal_permintaan',
        'created_at',
        'updated_at'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'idsiswa');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'idguru');
    }
}
