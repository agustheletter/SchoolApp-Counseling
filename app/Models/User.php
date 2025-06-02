<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nis',
        'nama',
        'email',
        'password',
        'avatar',
        'gender',
        'role',
        'username',
        'phone',
        'bio',
        'theme',
        'notification_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'notification_preferences' => 'array',
        'last_login_at' => 'datetime',
    ];

    /**
     * Check if the user has a given role.
     *
     * @param  string  $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Get the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'default-')) {
                return Storage::url('avatars/' . $this->avatar);
            }
            return Storage::url('avatars/' . $this->avatar);
        }
        
        if ($this->gender) {
            $defaultAvatar = $this->gender === 'male' ? 'default-male.png' : 'default-female.png';
            return Storage::url('avatars/' . $defaultAvatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=random';
    }

    /**
     * Update user's avatar.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return void
     */
    public function updateAvatar($file)
    {
        // Delete old avatar if exists
        if ($this->avatar) {
            Storage::disk('public')->delete('avatars/' . $this->avatar);
        }

        // Store new avatar
        $filename = $this->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('avatars', $filename, 'public');
        
        // Update avatar field
        $this->update(['avatar' => $filename]);
    }
    
    /**
     * Record the user's login information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function recordLogin($request)
    {
        $this->last_login_ip = $request->ip();
        $this->last_login_at = now();
        $this->save();
    }

    /**
     * Get the counselor associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function counselor()
    {
        return $this->hasOne(Counselor::class, 'idkonselor');
    }
}
