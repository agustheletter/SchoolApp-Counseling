<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counselor extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_counselor';

    protected $fillable = [
        'idkonselor',
        'pendidikan_terakhir',
        'jurusan_pendidikan',
        'spesialisasi',
        'pengalaman_kerja',
        'sertifikasi',
        'status',
        'tanggal_bergabung'
    ];

    protected $attributes = [
        'pendidikan_terakhir' => '-',
        'jurusan_pendidikan' => '-',
        'spesialisasi' => null,
        'pengalaman_kerja' => 0,
        'sertifikasi' => null,
        'status' => 'pending'
    ];

    protected $dates = ['deleted_at', 'tanggal_bergabung'];
}
