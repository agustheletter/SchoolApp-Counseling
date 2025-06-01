<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'tbl_siswa'; 
    protected $primaryKey = 'idsiswa'; 
    public $incrementing = true;
    protected $keyType = 'int'; 

    protected $fillable = [
        'nis', 'nisn', 'namasiswa', 'tempatlahir', 'tgllahir', 'jenkel', 'alamat',
        'idjurusan', 'idprogramkeahlian', 'idagama', 'tlprumah', 'hpsiswa',
        'idthnmasuk', 'photosiswa'
    ];

    protected $casts = [
        'tgllahir' => 'date:Y-m-d',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'idjurusan', 'idjurusan');
    }

    public function programKeahlian()
    {
        return $this->belongsTo(ProgramKeahlian::class, 'idprogramkeahlian', 'idprogramkeahlian');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class, 'idagama', 'idagama');
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photosiswa 
            ? asset('storage/' . $this->photosiswa)
            : asset('images/default-avatar.png');
    }
}