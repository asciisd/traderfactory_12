<?php

namespace App\Models;

use App\Notifications\SendVerifyEmail;
use App\Traits\Favorability;
use App\Traits\HasProfilePhoto;
use App\Traits\HasProgress;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Nova\Actions\Actionable;
use Nagy\LaravelRating\Traits\CanRate;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Actionable, HasProfilePhoto, TwoFactorAuthenticatable;
    use Favorability, HasProgress;
    use CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone', 'country', 'last_login_at',
        'utm_source', 'utm_content', 'utm_medium', 'utm_campaign', 'utm_term'
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
            'email_verified_at' => 'datetime',
            'last_login_at' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = [
        'profile_photo_url'
    ];

    /**
     * @return void
     */
    public function courses()
    {
        // TODO::create a pivot table for courses and users.
    }

    /**
     * Check if user owns specific course.
     */
    public function ownCourse($course_id): bool
    {
        return $this->orders()->where([
            'status' => 'SUCCESS',
            'orderable_id' => $course_id,
            'orderable_type' => Course::class,
        ])->count();
    }

    /**
     * One-to-many relationship with orders table.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if a user owns a specific book
     */
    public function ownBook($book_id): bool
    {
        return $this->orders()->where([
            'status' => 'SUCCESS',
            'orderable_id' => $book_id,
            'orderable_type' => Book::class,
        ])->count();

    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerifyEmail);
    }

    public function tapPhone()
    {
        return $this->phone;
    }

    public function ownOrder(mixed $course_id): bool
    {
        return $this->orders()->where([
            'status' => 'SUCCESS',
            'orderable_id' => $course_id,
            'orderable_type' => Course::class,
        ])->exists();
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $attributes['first_name'].' '.$attributes['last_name'],
        );
    }
}
