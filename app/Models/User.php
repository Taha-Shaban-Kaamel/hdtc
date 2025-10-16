<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public $translatable = ['first_name', 'second_name', 'bio'];

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

    /**
     * Get the enrollments for the user.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isEnrolledIn($courseId)
    {
        return $this
            ->enrollments()
            ->where('course_id', $courseId)
            ->where('status', 'active')
            ->exists();
    }


    

    /**
     * Get the enrolled courses for the user.
     */
    public function enrolledCourses()
    {
        return $this
            ->belongsToMany(Course::class, 'enrollments')
            ->using(Enrollment::class)
            ->withPivot('status', 'progress', 'grade', 'completion_date')
            ->withTimestamps();
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'first_name' => 'array',
        'second_name' => 'array',
        'bio' => 'array',
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

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }
    public function getFullNameAttribute()
    {
        $locale = app()->getLocale(); // اللغة الحالية (ar أو en)

        $first = is_array($this->first_name)
            ? ($this->first_name[$locale] ?? reset($this->first_name))
            : $this->first_name;

        $second = is_array($this->second_name)
            ? ($this->second_name[$locale] ?? reset($this->second_name))
            : $this->second_name;

        return trim("{$first} {$second}") ?: '---';
    }


    public function teaches($courseId)
    {
        return $this
            ->courses()
            ->where('courses.id', $courseId)
            ->exists();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_instructor', 'instructor_id', 'course_id');
    }
}
