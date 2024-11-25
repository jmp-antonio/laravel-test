<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        // 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    /* 
    Relationships
    */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /* 
    Scopes
    */
    public function scopeGetUsersByRoles(Builder $query, string | null $roles): Builder
    {
        return $query->when($roles, function ($query, $roles) {
            return $query->whereHas('roles', function ($subQuery) use ($roles) {
                $subQuery->whereIn('role_id', explode(',', $roles));
            });
        });
    }

    /* 
        Validation rules
    */
    public const VALIDATION_RULES = [
        'full_name' => ['required'],
        'email' => ['required', 'email', 'unique:users'],
        'roles' => ['required', 'array'],
    ];
}
