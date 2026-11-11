<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BelongsToTenant;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,BelongsToTenant;
    //Define immutable roles
    const ROLE_ADMIN='clinic_admin';
    const ROLE_DOCTOR='clinic_admin';
    const ROLE_RECEPTIONIST='receptionist';
    protected $fillable=[
        'name', 'email', 'password','tenant_id','role'

    ];
    protected $hidden=[
         'password','remember_token',

    ];
    //Authorization helpers
    public function isAdmin():bool{
        return $this->role===self::ROLE_ADMIN;

    }
    public function isDoctor():bool{
        return $this->role===self::ROLE_DOCTOR;

    }
    public function isReceptionist():bool{
        return $this->role===self::ROLE_RECEPTIONIST;

    }
    public function hasRole(array $roles):bool{
        return in_array($this->role,$roles);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
