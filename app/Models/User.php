<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tweets()
{
    return $this->hasMany(Tweet::class);
}

public function likes()
{
    return $this->hasMany(Like::class);
}


 // المستخدمين الذين يتابعهم هذا المستخدم
 public function following(): BelongsToMany
 {
     return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
 }

 // المستخدمون الذين يتابعون هذا المستخدم
 public function followers(): BelongsToMany
 {
     return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
 }

 public function isFollowing(User $user)
{
    return $this->following()->where('following_id', $user->id)->exists();
}
}
