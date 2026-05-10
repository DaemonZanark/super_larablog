<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'password',
        'bio',
        'avatar',
        'instagram_url',
        'twitter_url',
        'portfolio_url',
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->articles->each->delete();

            $user->comments()->delete();
            $user->likes()->detach();

            $user->followers()->detach();
            $user->following()->detach();
        });
    }

	public function articles()
	{
		return $this->hasMany(Article::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

    public function likes()
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'author_id', 'user_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'user_id', 'author_id')->withTimestamps();
    }

    public function isSubscribedTo(User $author)
    {
        return $this->following()->where('author_id', $author->id)->exists();
    }

    public function isAdmin()
    {
        return $this->is_admin === 1 || $this->is_admin === true;
    }

	public function subscriptions()
	{
		return $this->hasMany(Subscription::class);
	}
}
