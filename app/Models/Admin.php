<?php

namespace App\Models;

use App\Traits\HasActiveState;
use App\Traits\HasProfilePhoto;
use App\Traits\HasSuperState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasActiveState, HasSuperState, HasProfilePhoto;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_super' => 'boolean',
            'is_active' => 'boolean',
            'activated_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = [
        'profile_photo_url', 'is_active',
    ];

    /**
     * Get the timezone for the admin.
     */
    public function getTimezoneAttribute()
    {
        return $this->attributes['timezone'] ?? config('app.timezone', 'UTC');
    }
}
