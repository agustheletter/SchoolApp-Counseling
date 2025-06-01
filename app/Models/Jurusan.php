<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Jurusan extends Model
{
    use HasFactory; // , SoftDeletes;
    protected $table = 'tbl_jurusan';
    protected $primaryKey = 'idjurusan';
    public $incrementing = true;
    protected $keyType = 'int';

    // 'idprogramkeahlian' (nullable) ada di fillable jika Anda ingin mengisinya
    protected $fillable = ['namajurusan', 'kodejurusan', 'idprogramkeahlian'];
    // Atau jika 'idjurusan' juga ingin diisi manual saat seeding:
    // protected $fillable = ['idjurusan', 'namajurusan', 'kodejurusan', 'idprogramkeahlian'];


    // Jurusan merujuk ke satu ProgramKeahlian (melalui kolom 'idprogramkeahlian' di tabel ini)
    public function programKeahlian()
    {
        return $this->belongsTo(ProgramKeahlian::class, 'idprogramkeahlian', 'idprogramkeahlian');
    }

    // Jurusan memiliki banyak Siswa
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'idjurusan', 'idjurusan');
    }
}