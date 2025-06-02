<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counselor extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_counselor';

    protected $fillable = [
        'nip',
        'nama_konselor',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'no_hp',
        'pendidikan_terakhir',
        'spesialisasi',
        'status',
        'tanggal_bergabung',
        'photo_konselor'
    ];

    protected $casts = [
        'spesialisasi' => 'array',
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date'
    ];

    protected $dates = ['deleted_at'];
}
