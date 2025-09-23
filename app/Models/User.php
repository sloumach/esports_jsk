<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function teamsAsPlayer()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    // User belongs to many teams as staff
    public function teamsAsStaff()
    {
        return $this->belongsToMany(Team::class, 'team_staff')
                    ->withPivot('staff_role_id', 'assigned_at')
                    ->withTimestamps();
    }

    // User has many authored news
    public function news()
    {
        return $this->hasMany(News::class, 'author_id');
    }

    // User has many created events
    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }


}
