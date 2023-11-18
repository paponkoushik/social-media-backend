<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function followers(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                User::class,
                'followers',
                'user_id',
                'follower_id'
            )->withTimestamps();
    }

    public function following(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                User::class,
                'followers',
                'follower_id',
                'user_id'
            )->withTimestamps();
    }

    public function follow(User $user)
    {
        $this->following()->attach($user->id);
    }

    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('follower_id', $user->id)->exists();
    }

    public function tweets(): HasMany
    {
        return $this->hasMany(Tweet::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
