<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * Attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone',
        'locale',
        'status',
        'last_login_at',
        'email_verified_at',
    ];

    /**
     * Attributes hidden in JSON responses.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // User has many roles (Many-to-Many)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // User has many activity logs
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /* ==========================
     |   HELPERS
     ========================== */

    // Check if user has a role
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
