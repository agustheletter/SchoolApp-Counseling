<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counselor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_counselor';

    protected $fillable = [
        'nip',
        'nama_konselor',
        'gelar_depan',
        'gelar_belakang',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'email',
        'no_hp',
        'pendidikan_terakhir',
        'jurusan_pendidikan',
        'spesialisasi',
        'pengalaman_kerja',
        'sertifikasi',
        'status',
        'tanggal_bergabung',
        'photo_konselor'
    ];

    protected $dates = [
        'tanggal_lahir',
        'tanggal_bergabung'
    ];

    public function getNameWithTitleAttribute()
    {
        $name = [];
        if ($this->gelar_depan) $name[] = $this->gelar_depan;
        $name[] = $this->nama_konselor;
        if ($this->gelar_belakang) $name[] = $this->gelar_belakang;
        return implode(' ', $name);
    }
}
