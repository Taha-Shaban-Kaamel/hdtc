<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public $translatable = ['first_name', 'second_name'];

    protected $fillable = [
        'user_name',
        'provider',
        'provider_id',
        'first_name',
        'second_name',
        'birth_date',
        'gender',
        'email',
        'password',
        'user_type_id',
        'avatar',
        'phone',
        'bio',
        'birth_date',
        'gender',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'first_name' => 'array',
        'second_name' => 'array',
    ];

    /**
     * Get the user type that owns the user.
     */
    public function userType()
    {
        return $this->belongsTo(UsersType::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
