<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role', // S'assurer que 'role' est dans les fillable
        'phone',
        'city',
        'postal_code',
        'email_verified_at'
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
    ];

    public function artisan()
    {
        return $this->hasOne(Artisan::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function isArtisan(): bool
    {
        return $this->role === 'artisan';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function hasCompletedProfile()
    {
        if ($this->role === 'artisan') {
            return $this->artisan !== null;
        }
        return $this->city !== null && $this->postal_code !== null && $this->phone !== null;
    }
}
