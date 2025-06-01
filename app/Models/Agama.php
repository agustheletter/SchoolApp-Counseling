<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model{

    use HasFactory;
    protected $table = 'tbl_agama'; 
    protected $primaryKey = 'idagama'; 
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['agama']; 

    public function siswas()
    {
        
        return $this->hasMany(Siswa::class, 'idagama', 'idagama');
    }

}