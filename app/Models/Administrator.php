<?php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Administrator extends Model
{
    use SoftDeletes;

    protected $table = 'administrators';
    
    protected $fillable = [
        'username',
        'nama_lengkap',
        'email',
        'password',
        'role',
        'status',
        'no_hp',
        'alamat',
        'photo_profile',
        'keterangan',
        'last_login'
    ];

    protected $hidden = [
        'password'
    ];

    protected $dates = [
        'last_login',
        'deleted_at'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];
}