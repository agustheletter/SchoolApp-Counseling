<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingRequest extends Model
{
    use HasFactory;

    protected $table = 'tbl_konselingrequest';
    
    protected $fillable = [
        'idsiswa',
        'idguru',
        'kategori',
        'tanggal_permintaan',
        'deskripsi',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'idsiswa', 'id');
    }

    public function counselor()
    {
        return $this->belongsTo(User::class, 'idguru', 'id');
    }

    public function getPriorityClassAttribute()
    {
        return match ($this->status) {
            'Pending' => 'priority-medium',
            'Approved' => 'priority-low',
            'Rejected' => 'priority-high',
            default => '',
        };
    }

    public function getPriorityBadgeAttribute()
    {
        return match ($this->status) {
            'Pending' => 'warning',
            'Approved' => 'success',
            'Rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function getPriorityLabelAttribute()
    {
        return match ($this->status) {
            'Pending' => 'Menunggu',
            'Approved' => 'Disetujui',
            'Rejected' => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }
}