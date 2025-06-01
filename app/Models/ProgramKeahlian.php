<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes; // Jika Anda menggunakan soft deletes

class ProgramKeahlian extends Model
{
    use HasFactory; // , SoftDeletes; // Aktifkan jika menggunakan soft deletes
    protected $table = 'tbl_programkeahlian';
    protected $primaryKey = 'idprogramkeahlian';
    public $incrementing = true;
    protected $keyType = 'int';

    // Kolom yang bisa diisi massal (tidak ada 'idjurusan')
    protected $fillable = ['namaprogramkeahlian', 'kodeprogramkeahlian'];
    // Atau jika 'idprogramkeahlian' juga ingin diisi manual saat seeding:
    // protected $fillable = ['idprogramkeahlian', 'namaprogramkeahlian', 'kodeprogramkeahlian'];


    // Program Keahlian dimiliki oleh banyak Siswa
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'idprogramkeahlian', 'idprogramkeahlian');
    }

    // Program Keahlian bisa dirujuk oleh banyak Jurusan (melalui tbl_jurusan.idprogramkeahlian)
    public function jurusans()
    {
        return $this->hasMany(Jurusan::class, 'idprogramkeahlian', 'idprogramkeahlian');
    }
}