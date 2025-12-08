<?php

namespace App\Models;

use Encrypt;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = true;

    protected $fillable = [
        'id',
        'name',
        'last_name',
        // 'dui',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
        'remember_token',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmailQueued);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'model_id');
    }

    public function format()
    {
        return [
            "id" => Encrypt::encryptValue($this->id) ?? null,
            "name" => $this?->name,
            "email" => $this?->email,
            "rol" => $this?->role?->name,
        ];
    }

    public function userHasRole($rolesSearched)
    {
        $roles = $this->getRoleNames();

        foreach ($rolesSearched as $key => $role) {
            foreach ($roles as $key => $roleName) {
                if ($roleName == $role) return true;
            }
        }

        return false;
    }
}
