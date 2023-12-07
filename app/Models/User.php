<?php

declare(strict_types = 1);

namespace App\Models;

use App\Http\Notification\ResetPassword as ResetPasswordNotification;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as AuthCanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends BaseModel implements JWTSubject, AuthenticatableContract, AuthCanResetPassword
{
    use Authenticatable, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName', 'email', 'inviteToken', 'password', 'isAdmin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Retrieve a user by the given email.
     *
     * @param string $email
     *
     * @return User
     */
    public static function retrieveByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    //phpcs:ignore
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    //phpcs:ignore
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * Return full name.
     *
     * @return void
     */
    public function getNameAttribute()
    {
        return trim($this->firstName." ".$this->LastName);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function hours(): HasMany
    {
        return $this->hasMany(Hour::class);
    }
}
